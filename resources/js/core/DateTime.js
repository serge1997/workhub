export class DateTime
{
    constructor(){}

    static now() {

    }

    static enFormat(date) {
        const dateArray = [
            date.getFullYear(),
            `${date.getMonth() + 1}`.padStart(2, '0'),
            `${date.getDate()}`.padStart(2, '0'),
            `${date.getHours()}`.padStart(2, '0'),
            `${date.getMinutes()}`.padStart(2, '0'),
            `${date.getSeconds()}`.padStart(2, '0')
        ];
        const [year, month, day, hour, min, second] = dateArray;

        return `${year}-${month}-${day} ${hour}:${min}:${second}`;
    }

    static time(date){
        const time = date.split(' ').pop();
        return time.match(/\d\d:\d\d/g)[0];
    }


}
