    function test() {
        for(i = 1; i < 60; i++) {
            console.log(getRelativeMinuteString("", 60 * i));
        }
        for(i = 1; i < 60; i++) {
            console.log(getRelativeHourString("", 3600 * i));
        }
        for(i = 1; i < 60; i++) {
            console.log(getRelativeDayString("", 3600 * 24 * i));
        }
        for(i = 1; i < 8; i++) {
            console.log(getRelativeWeekString("", 3600 * 24 * 7 * i));
        }
    }


    function rewriteTimeStamps() {
        var timestamps = document.getElementsByClassName("news-timestamp");
        for(i = 0; i < timestamps.length; i++) {
            timestamps[i].innerHTML = getRelativeTimeString(timestamps[i].innerHTML);
        }
    }

    function getDifferenceInSec(timestamp) {
        var now = new Date();
        var difference = now.getTime() - timestamp;
        return difference/1000;
    }

    function getDateFromTimestamp(timestamp) {
        var now = new Date();
        var difference = now - timestamp;
        var seconds = difference/1000;

        return getDays(seconds);
//        return sada.getHours() + ":" + sada.getMinutes() + '\n' + difference.getMinutes() + ":" + difference.getSeconds();
    }

    function getRelativeTimeString(timestamp) {

        timestamp *= 1000;  // php fix
        var now = new Date();
        var difference = now - timestamp;
        var seconds = difference/1000;

        var toReturn = "Novost je objavljena prije ";

        if(getMinutes(seconds) < 1) {
            return toReturn + "par sekundi";
        }
        if(getHours(seconds) < 1) {
            return getRelativeMinuteString(toReturn, seconds);
        }
        if(getDays(seconds) < 1) {
            return getRelativeHourString(toReturn, seconds);
        }
        if(getWeeks(seconds) < 1) {
            return getRelativeDayString(toReturn, seconds);
        }
        if(getMonths(seconds) < 1) {
            return getRelativeWeekString(toReturn, seconds);
        }
        return getFullDateString(timestamp * 1000);
    }

    function getFullDateString(seconds) {
        var toDisplay = new Date(seconds);

        return 'Novost je objavljena ' + parseInt(toDisplay.getDay() + 1) + '.' + parseInt(toDisplay.getMonth() + 1) + '.' + toDisplay.getFullYear() + '.';

    }

    function getRelativeMinuteString(toReturn, seconds) {
        var minutes = parseInt(getMinutes(seconds));
        toReturn += minutes;


        if(minutes % 10 == 1 && minutes != 11) {
            toReturn += " minutu";
        }
        else if (minutes > 5 && minutes < 21) {
            toReturn += " minuta";
        }
        else if(minutes % 10 < 5 && minutes % 10 != 0) {
            toReturn += " minute";
        }
        else {
            toReturn += " minuta";
        }


        return toReturn;
    }

    function getRelativeHourString(toReturn, seconds) {
        var hours = parseInt(getHours(seconds));
        toReturn += hours;

        if(hours % 10 == 1 && hours != 11) {
            toReturn += " sat";
        }
        else if (hours > 5 && hours < 21) {
            toReturn += " sati";
        }
        else if(hours % 10 < 5 && hours % 10 != 0) {
            toReturn += " sata";
        }
        else {
            toReturn += " sati";
        }

        return toReturn;
    }

    function getRelativeDayString(toReturn, seconds) {
        var days = parseInt(getDays(seconds));
        toReturn += days;

        if(days % 10 == 1 && days != 11) {
            toReturn += " dan";
        }
        else {
            toReturn += " dana";
        }

        return toReturn;
    }

    function getRelativeWeekString(toReturn, seconds) {
        var weeks = parseInt(getWeeks(seconds));
        toReturn += weeks;

        if(weeks == 1) {
            toReturn += " sedmicu";
        }
        else {
            toReturn += " sedmice";
        }

        return toReturn;
    }


    function getMinutes(seconds) {
        return seconds / 60;
    }
    function getHours(seconds) {
        return getMinutes(seconds) / 60;
    }
    function getDays(seconds) {
        return getHours(seconds) / 24;
    }
    function getWeeks(seconds) {
        return getDays(seconds) / 7;
    }

    function getMonths(seconds) {
        //assume every month is 4 weeks
        return getWeeks(seconds) / 4;
    }
