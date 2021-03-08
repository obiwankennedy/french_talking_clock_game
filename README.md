# Talking Clock For french learners

[Online Demo](http://heures.renaudguezennec.eu)

## Requirements

* ffmpeg
* python3
* argparse
* time
* readchar
* sys
* os
* numpy
* subprocess

## Requirement for the website

* jquery
* php
* url\_rewrite (apache mod)


## Record your voice

To record and generate all files to create your voice, you can use this command:
```python
./enregistre_horloge_fr.py -o audio/sample -g 
```

But we recommand to make it in 2 steps:
```python
./enregistre_horloge_fr.py -o audio/sample
```
Edit all samples to cut silence manually, improve the volume, clarity of each sample.
Then, you can generate the final files.

```python
./enregistre_horloge_fr.py -o audio/sample -g

```



## Convert all files into Ogg (to reduce the size)

```
$ for i in audio/*.wav; do filename=`basename $i`; name=`echo $ | awk -F '.' '{print $1}'`; ffmpeg -i $i -c:a libvorbis -qscale 255 ogg/name.ogg; done
```

Then you can create an archive with all the ogg and find a way to send it to me.
