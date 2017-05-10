var Twitter = require('twitter');

var client = new Twitter({
    consumer_key: '',
    consumer_secret: '',
    access_token_key: '',
    access_token_secret: ''
})

var pos = 0

function tweetPi() {

    var p = String(pos)
    var pi = '3.14159...'
    var num = pi.charAt(pos)
    var position = p.charAt(p.length - 1)
    console.log(position)
    var tens = p.charAt(p.length - 2)
    console.log(tens)
    var end = null

    if (position == '1' && tens != '1') {
        end = 'st';
    } else if (position == '2' && tens != '1') {
        end = 'nd';
    } else if (position == '3' && tens != '1') {
        end = 'rd';
    } else {
        end = 'th';
    }

    var result = 'The ' + p + end + ' position of Pi is ' + num + '.'

    client.post('statuses/update', {
        status: result
    }, function (error, tweet, response) {
        if (error) throw error;
        console.log(tweet); // Tweet body. 
        console.log(response); // Raw response object. 
    })

    pos++
}

tweetPi()
setInterval(tweetPi, 1000)