#!/usr/bin/python3

import subprocess
from os import system, name
import numpy as np
import time
import readchar
import tempfile
import os
import os.path
from os import path
import argparse
import sys

def merge_array(a1,a2):
    return a1 + a2

def merge_sound(args, dest, dry_run):
    args=merge_array(merge_array(["sox"], args), [dest])
    print("parameters for merge sound: {}".format(args))
    if not dry_run:
        subprocess.call(args)

def add_suffixe(dest, suffixe):
    return dest.replace(".wav","{}.wav".format(suffixe))


def clear_screen():
    if name == 'nt':
        _ = system('cls')
    else:
        _ = system('clear')

def optimize_sound(source, dry_run):
    dest = add_suffixe(source, "_opti")
    if dry_run:
        return dest
    subprocess.call(['sox',source, dest,'compand','0.3,1','6:-70,-60,-20','-5','-90','0.2'])
    return dest

def clean_up_sound(source, dry_run):
    dest = add_suffixe(source, "_clean")
    if dry_run:
        return dest
    subprocess.call(['sox',source, dest,'silence', '-l','1','0.1','0%','-1','0.1','0%'])
    return dest

def record_file(word, dry_run, fast):
    satisfied = False
    dest = "{}{}".format(word,".wav")
    if dry_run or path.exists(dest):
        return dest
    while not satisfied:
        clear_screen()
        time.sleep(0.5)
        print("Dites: {}".format(word))
        args=["arecord","-q","-d","3","-D","pulse","-fdat", dest]
        subprocess.call(args)
        if not fast:
            time.sleep(1)
            clear_screen()
            subprocess.call(["aplay", dest])
            char=""
            while char not in ["o", "n", "\n"]:
                print("Satisfait ? O/n")
                char = readchar.readchar()

            if char == 'o' or char == '\n':
                satisfied=True
        else:
            satisfied = True

    return dest


def build_record_data(unity, tens, words):
    return merge_array(merge_array(unity, tens), words)


def build_heures(sentences):
    heures=[]
    for i in range(0,24):
        if i == 0:
            heures.append([sentences[22]])
        elif i == 12:
            heures.append([sentences[21]])
        elif i < 17:
            heures.append([sentences[i],sentences[26]])
        elif i< 20:
            heures.append([sentences[10],sentences[i-10],sentences[26]])
        elif i== 20:
            heures.append([sentences[17],sentences[26]])
        elif i== 21:
            heures.append([sentences[17],sentences[23],sentences[1],sentences[26]])
        else: 
            heures.append([sentences[17],sentences[i-20],sentences[26]])
    return heures

def build_minutes(sentences):
    minutes=[]
    for i in range(1,60):
        if i < 17:
            minutes.append([sentences[i]])
        elif i < 20:
            minutes.append([sentences[10],sentences[i-10]])
        elif i < 30:
            if i == 21:
                minutes.append([sentences[17],sentences[23],sentences[1]])
            elif i == 20:
                minutes.append([sentences[17]])
            else:
                minutes.append([sentences[17],sentences[i-20]])
        elif i < 40:
            if i == 31:
                minutes.append([sentences[18],sentences[23],sentences[1]])
            elif i == 30:
                minutes.append([sentences[18]])
            else:
                minutes.append([sentences[18],sentences[i-30]])
        elif i < 50:
            if i == 41:
                minutes.append([sentences[19],sentences[23],sentences[1]])
            elif i == 40:
                minutes.append([sentences[19]])
            else:
                minutes.append([sentences[19],sentences[i-40]])
        elif i < 60:
            if i == 51:
                minutes.append([sentences[20],sentences[23],sentences[1]])
            elif i == 50:
                minutes.append([sentences[20]])
            else:
                minutes.append([sentences[20],sentences[i-50]])


    minutes.append([sentences[25],sentences[5]])#-5
    minutes.append([sentences[25],sentences[10]])#-10
    minutes.append([sentences[25],sentences[27],sentences[24]])#-15
    minutes.append([sentences[25],sentences[17]])#-20
    minutes.append([sentences[25],sentences[17],sentences[5]])#-25
    return minutes



def merge_horaire(horaires, dry_run):
    for h in horaires:
        files_to_merge=["{}{}".format(name, "_clean_opti.wav") for name in h]
        filename="../{}{}".format('_'.join(h), ".wav")
        merge_sound(files_to_merge, filename, dry_run)

            
        

def build_horaire(heures, minutes):
    horaires=[]
    for h in heures:
        horaires.append(h)
        for mi in minutes:
            horaires.append(merge_array(h, mi))
        
    return horaires
# Main program


def main(argv):
    print("Prepare data wizard")
    parser = argparse.ArgumentParser(description='French Talking Clock.')
    parser.add_argument('-g', '--generate',dest="generate", action='store_true',
                        help='Generate all audio files from audio sample.')
    parser.add_argument('-o', '--output', dest='output',
                        help='output directory')
    parser.add_argument('-d', '--dry_run', dest='dry_run', default="",  action='store_true',
                        help='dry execution, no file will be created.')
    parser.add_argument('-f', '--fast-recording',dest="fast", action='store_true',
                        help='Enable fast recording - no audio check after recording')
    parser.set_defaults(dry_run=False)
    parser.set_defaults(fast=False)
    parser.set_defaults(generate=False)

    args = parser.parse_args()

    dry_run=args.dry_run
    generate=args.generate



    tmp = args.output if len(args.output) else tempfile.mkdtemp(dir="./")
    if not os.path.exists(tmp) and not dry_run:
        os.makedirs(tmp)
    if not dry_run:
        os.chdir(tmp)
    print("Execution Directory: {}".format(tmp))


    unity=["un","une","deux","trois","quatre","cinq","six","sept","huit","neuf"]
    tens=["dix","onze","douze","treize","quatorze","quinze","seize","vingt","trente","quarante","cinquante"]
    words=["midi","minuit","et","quart","moins", "heure", "le"]


    sentences=build_record_data(unity, tens, words)
    for text in sentences:
        file = record_file(text, dry_run, args.fast)
        cleaned = clean_up_sound(file, dry_run)
        if not dry_run:
            os.remove(file)
        optimize_sound(cleaned, dry_run)
        if not dry_run:
            os.remove(cleaned)

    print("All samples have been recorded")
    print("Don't hesitate to edit audio files here {} to improve the quality of your data".format(tmp))
    if generate:
        print("Starting Sentence Generation")
        minutes=build_minutes(sentences)
        heures=build_heures(sentences)
        horaire=build_horaire(heures,minutes)
        merge_horaire(horaire,dry_run)
        print("End of Sentence Generation")

if __name__ == '__main__':
    main(sys.argv[1:])
