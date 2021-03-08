/*  Bibliothèque JavaScript version 0.1
 *  Autor: Renaud Guezennec
*/

function audioPlayer()
{
	         $.ajax({
                            url: "api/audiofileselector",// no extension because of rewrite url apache.
                            type: "POST",
                            data: $('#main').serialize()
                            }).done(function(msg) {
                                $('#content').html($.parseJSON(msg));
                            });
}
