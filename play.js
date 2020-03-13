function ok() {
    // alert($(this).attr('x') + ' ' + $(this).attr('y'));
    // return;
    $.ajax({
        url: 'turn.php',
        method: 'post',
        data: {'id': id,
            'x' : $(this).attr('x'),
            'y' : $(this).attr('y')
        },
        success: function (data) {
            // alert(data);
            // console.log(data);
            // $('#msg').val(data);
            return;
            // alert(data);
            // if (parseInt(data) == -1) {
                // console.log('exit');
                // window.location.href = 'index.php';
                // self.location = 'https://index.php';
                // return;
            // }
        }
    });
    // alert("end");
}

function upd_first() {
    // window.location.href = 'index.php';

    $.ajax({
        url: 'get.php',
        method: 'post',
        data: {'id' : id},
        success: function(data) {
            // console.log(data);
            // return;
            // alert(data);
            if (data == '-1') {
                // console.log('exit');
                window.location.href = 'index.php';
                // self.location = 'https://index.php';
                return;
            }
            let mas = JSON.parse(data);
            // console.log(data);
            // console.log(mas);
            let m = parseInt(mas['k']);
            let n = parseInt(mas['n']);
            // console.log(n);
            let map = mas['map'];
            let side = 500;
            let sq_side = side / n;
            let imge = '<img src="e.png" width="' + (sq_side).toString() + '" height="' + (sq_side).toString() + '" alt="e">';
            let imgx = '<img src="x.png" width="' + (sq_side).toString() + '" height="' + (sq_side).toString() + '" alt="x">';
            let imgo = '<img src="o.png" width="' + (sq_side).toString() + '" height="' + (sq_side).toString() + '" alt="o">';
            for (let i = 0; i < n; i++) {
                for (let j = 0; j < n; j++) {
                    // console.log(i, ' ', j); toString(i * sq_side) toString(j * sq_side)
                    // console.log((i * sq_side * 5));
                    // console.log(j * sq_side * 5);
                    let $o;
                    if (map[i][j] === 0) {
                        $o = $('<div id="debug" style="position: absolute ; left: ' + (i * sq_side).toString() + 'px; top: ' + (j * sq_side).toString() + 'px">' + imge + '</div>');
                        $o.attr('v', 0);
                    }
                    if (map[i][j] === 1) {
                        $o = $('<div style="position: absolute; left: ' + (i * sq_side).toString() + 'px; top: ' + (j * sq_side).toString() + 'px">' + imgx + '</div>');
                        $o.attr('v', 1);
                    }
                    if (map[i][j] === 2) {
                        $o = $('<div style="position: absolute; left: ' + (i * sq_side).toString() + 'px; top: ' + (j * sq_side).toString() + 'px">' + imgo + '</div>');
                        $o.attr('v', 2)
                    }
                    $o.attr('x', i);
                    $o.attr('y', j);
                    $o.click(ok);
                    $('#mapid').append($o);
                }
                // $('#mapid').append('<br>');
            }
        }
    });
}

function upd() {
    // window.location.href = 'index.php';

    $.ajax({
        url: 'get.php',
        method: 'post',
        data: {'id' : id},
        success: function(data) {
            // alert("YES");
            // console.log(data);
            // return;
            if (data === '-1') {
                // console.log('exit');
                // window.location.href = 'index.php';
                // self.location = 'https://index.php';
                return;
            }

            let mas = JSON.parse(data);
            // let mas = JSON.parse(json['cash']);
            let turn = mas['turn'];
            // alert(mas);
            // console.log(data);
            // console.log(mas);
            let m = parseInt(mas['k']);
            let n = parseInt(mas['n']);
            // alert(mas['turn']);
            if (parseInt(turn) == 3) {
                $('#msg').text("X wins");
            }
            if (parseInt(turn) == 4) {
                $('#msg').text("O wins");
            }

            // console.log(n);
            let map = mas['map'];
            // alert(map);
            let side = 500;
            let sq_side = side / n;
            let imge = '<img src="e.png" width="' + (sq_side).toString() + '" height="' + (sq_side).toString() + '" alt="no img">';
            let imgx = '<img src="x.png" width="' + (sq_side).toString() + '" height="' + (sq_side).toString() + '" alt="no img">';
            let imgo = '<img src="o.png" width="' + (sq_side).toString() + '" height="' + (sq_side).toString() + '" alt="no img">';
            for (let i = 0; i < n; i++) {
                for (let j = 0; j < n; j++) {
                    // console.log(i, ' ', j); toString(i * sq_side) toString(j * sq_side)
                    // console.log((i * sq_side * 5));
                    // console.log(j * sq_side * 5);
                    // if (map[i][j] == $(["'x' = \"" . strval(i) . '"']['y = ' . j"'"]))
                    let z = "div[x = '" + (i).toString() + "'][y = '" + (j).toString() + "']";
                    // alert(z);
                    let images = $(z).map(function () {
                        return $(this).attr('v');
                    }).get();
                    // alert(images);
                    if (parseInt(images[0]) == parseInt(map[i][j])) {
                        // alert("ok");
                    } else {
                        // alert("NO");
                        let t = '';
                        if (parseInt(map[i][j]) === 0) {
                            t = 'e';
                        }
                        if (parseInt(map[i][j]) === 1) {
                            t = 'x';
                        }
                        if (parseInt(map[i][j]) === 2) {
                            t = 'o';
                        }
                        // alert(z);
                        // $('div[x=' + i + '][y=' + j + ']')[0].find('img').attr('src', t +  '.png');
                        $(z).find('img').attr('src',  t + '.png');
                        // $(z).attr('v',  parseInt(map[i][j]).toString());
                    }
                    // $(z).find('img').attr('src',  'x.png');
                    // if (intval($().attr("v"))) == intval(map[i][j])) {
                    // } else {
                    // }
                }
                // $('#mapid').append('<br>');
            }
        }
    });
}

function start() {
    upd_first();
    // upd();
    setInterval(upd, 1);
}

$(document).ready(start);
