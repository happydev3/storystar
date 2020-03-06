function countChar(val, lim) {


    var string = val.value;

    var len = 0;
    for (var n = 0; n < string.length; n++) {
        var c = string.charCodeAt(n);
        if (c < 128) {
            len++;
        }
        else if ((c > 127) && (c < 2048)) {
            len = len + 2;
        }
        else {
            len = len + 3;
        }
    }

    if (len >= lim) {
        val.value = substr_utf8_bytes(string, 0, lim);
        $('#the_story').val(val.value);
        $('#charNum').text(0);
    } else {
        $('#charNum').text(aadFormat(lim - len));
    }
}
function aadFormat(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
function encode_utf8(s) {
    return unescape(encodeURIComponent(s));
}

function substr_utf8_bytes(str, startInBytes, lengthInBytes) {


    var resultStr = '';
    var startInChars = 0;

    // scan string forward to find index of first character
    // (convert start position in byte to start position in characters)

    for (bytePos = 0; bytePos < startInBytes; startInChars++) {

        // get numeric code of character (is >128 for multibyte character)
        // and increase "bytePos" for each byte of the character sequence

        ch = str.charCodeAt(startInChars);
        bytePos += (ch < 128) ? 1 : encode_utf8(str[startInChars]).length;
    }

    // now that we have the position of the starting character,
    // we can built the resulting substring

    // as we don't know the end position in chars yet, we start with a mix of
    // chars and bytes. we decrease "end" by the byte count of each selected
    // character to end up in the right position
    end = startInChars + lengthInBytes - 1;

    for (n = startInChars; startInChars <= end; n++) {
        // get numeric code of character (is >128 for multibyte character)
        // and decrease "end" for each byte of the character sequence
        ch = str.charCodeAt(n);
        end -= (ch < 128) ? 1 : encode_utf8(str[n]).length;

        resultStr += str[n];
    }

    return resultStr;
}