//instant execute
$(document).ready(function () {
    putDataInFields();
});

function testInput(event) {
    if (this.type != 'number') {
        if (this.id == 'curp' || this.id == 'filial1Curp' || this.id == 'filial2Curp' || this.id == 'inputSearch') {

            var value = String.fromCharCode(event.which);
            var pattern = new RegExp("^[a-zA-Z0-9]+$");
            return pattern.test(value);

        } else {
            var value = String.fromCharCode(event.which);
            var pattern = new RegExp(/[a-zåäö ]/i);
            return pattern.test(value);
        }
    }

}

$('input').bind('keypress', testInput);

//al values in uppercase
$(function () {
    $('input').keyup(function () {
        this.value = this.value.toLocaleUpperCase();
    });

});

// change values of municipio
$('#registerState').on('change', function () {
    var current = this.value;
    $('#registerMunicipio').empty();

    if (current == 0) {
        $("#registerMunicipio").attr('disabled', 'disabled');
        document.getElementById("registerMunicipio").selectedIndex = 0;
    } else {
        $('#registerMunicipio').prop("disabled", false);
        changeMunicipio(this.value);
    }
});

function changeMunicipio(current) {
    $.ajax({
        url: 'municipios.php',
        type: 'POST',
        data: {
            id_state: current
        },
        success: function (resultado) {
            $('#registerMunicipio').append(resultado);
        }
    });
}

function clearAllInputs() {
    $('#curp').val('');
    $('#name').val('');
    $('#lastName1').val('');
    $('#lastName2').val('');
    $('#registersexo').val('');
    $('#registerState').val('');
    $('#registerMunicipio').val('');
    $('#birthDayDay').val('');
    $('#birthDayMonth').val('');
    $('#birthDayYear').val('');
    $('#filial1Name').val('');
    $('#filial1LastName1').val('');
    $('#filial1LastName2').val('');
    $('#filial1Curp').val('');
    $('#filial1Sexo').val('');
    $('#filial1Country').val('');
    $('#filial2Name').val('');
    $('#filial2LastName1').val('');
    $('#filial2LastName2').val('');
    $('#filial2Curp').val('');
    $('#filial2Sexo').val('');
    $('#filial2Country').val('');
    $('#certificateNumber').val('');
    $('#registerDate').val('');
    $('#book').val('');
    $('#actaNumber').val('');
    $('#oficialia').val('');
    $('#identifierElectronic').val('');
    $('#registerDay').val('');
    $('#registerMonth').val('');
    $('#registerYear').val('');
    $('#registerMunicipio').prop("disabled", "disabled");
}


$("#buttonDelete").on("click", function (e) {
    $('#deleteModal').modal('show');
});

$("#demo").on("click", function (e) {
    //get all values in form
    let jsonObject = new Array();

    jsonObject.push({
        curp: $('#curp').val(),
        name: $('#name').val(),
        lastName1: $('#lastName1').val(),
        lastName2: $('#lastName2').val(),
        sex: $('#registersexo').val(),
        state: $('#registerState').val(),
        municipio: $('#registerMunicipio').val(),
        birthday: {
            day: $('#birthDayDay').val(),
            month: $('#birthDayMonth').val(),
            year: $('#birthDayYear').val()
        },
        personFiliales: {
            person1: {
                name: $('#filial1Name').val(),
                lastName1: $('#filial1LastName1').val(),
                lastName2: $('#filial1LastName2').val(),
                curp: $('#filial1Curp').val(),
                sex: $('#filial1Sexo').val(),
                country: $('#filial1Country').val(),
            },
            person2: {
                name: $('#filial2Name').val(),
                lastName1: $('#filial2LastName1').val(),
                lastName2: $('#filial2LastName2').val(),
                curp: $('#filial2Curp').val(),
                sex: $('#filial2Sexo').val(),
                country: $('#filial2Country').val(),
            }
        },
        cerificationNumber: $('#certificateNumber').val(),
        registerDate: $('#registerDate').val(),
        book: $('#book').val(),
        actaNumber: $('#actaNumber').val(),
        oficialia: $('#oficialia').val(),
        electronicIdentiier: $('#identifierElectronic').val(),
        registerDate: {
            day: $('#registerDay').val(),
            month: $('#registerMonth').val(),
            year: $('#registerYear').val()
        }
    });

    $.ajax({
        url: 'submit_register.php',
        type: 'POST',
        data: {
            json: jsonObject,
        },
        success: function (resultado) {
            console.log(resultado);
        }

    });

});

//newRegister

$("#newRegister").on("submit", function (e) {

    //get all values in form
    let jsonObject = new Array();

    jsonObject.push({
        curp: $('#curp').val(),
        name: $('#name').val(),
        lastName1: $('#lastName1').val(),
        lastName2: $('#lastName2').val(),
        sex: $('#registersexo').val(),
        state: $('#registerState').val(),
        municipio: $('#registerMunicipio').val(),
        birthday: {
            day: $('#birthDayDay').val(),
            month: $('#birthDayMonth').val(),
            year: $('#birthDayYear').val()
        },
        personFiliales: {
            person1: {
                name: $('#filial1Name').val(),
                lastName1: $('#filial1LastName1').val(),
                lastName2: $('#filial1LastName2').val(),
                curp: $('#filial1Curp').val(),
                sex: $('#filial1Sexo').val(),
                country: $('#filial1Country').val(),
            },
            person2: {
                name: $('#filial2Name').val(),
                lastName1: $('#filial2LastName1').val(),
                lastName2: $('#filial2LastName2').val(),
                curp: $('#filial2Curp').val(),
                sex: $('#filial2Sexo').val(),
                country: $('#filial2Country').val(),
            }
        },
        cerificationNumber: $('#certificateNumber').val(),
        registerDate: $('#registerDate').val(),
        book: $('#book').val(),
        actaNumber: $('#actaNumber').val(),
        oficialia: $('#oficialia').val(),
        electronicIdentiier: $('#identifierElectronic').val(),
        registerDate: {
            day: $('#registerDay').val(),
            month: $('#registerMonth').val(),
            year: $('#registerYear').val()
        }
    });

    //revision de que todo este completado.
    $.ajax({
        url: 'submit_register.php',
        type: 'POST',
        data: {
            json: jsonObject,
        },
        beforeSend: function () {
            //$('#loadingModal').modal('show');
            $('#loadingModal').modal({ backdrop: 'static', keyboard: false, show: true });
            $('#loadingModal').modal('toggle');
        },
        success: function (resultado) {
            //console.log(resultado);
            $('#loadingModal').modal('toggle');
            $('#viewDataInserted').prop("href", "./view_user.php?curp=" + jsonObject[0].curp + "");
            $('#completedModal').modal('show');
            clearAllInputs();
        }

    });

    e.preventDefault();
});

function putDataInFields() {
    curpVal = $('#curpVal').text(); // curp actual

    if ($("#form-list")[0]) { //run only in list

        $('#buttonBack').removeClass('d-none');
        $('#buttonDelete').removeClass('d-none');
        $('input').prop("disabled", true);
        $('select').prop("disabled", true);
        $('button[type="submit"]').addClass('d-none');
        //buttonDelete

        if (curp != undefined) { //run if curp is declarated
            $.ajax({
                url: 'get_list_user.php',
                type: 'POST',
                data: {
                    curp: curpVal,
                },
                success: function (resultado) {
                    parse = $.parseJSON(resultado);
                    console.log(parse);

                    filial1 = parse.personFiliales.person1;
                    filial2 = parse.personFiliales.person2;

                    $('#registerState').val(parse.state);
                    $('#registerMunicipio').remove();
                    $('#textMunicipio').removeClass('d-none');
                    $('#textMunicipio').val(parse.municipioName);
                    $('#curp').val(parse.curp);
                    $('#name').val(parse.name);
                    $('#lastName1').val(parse.lastName1);
                    $('#lastName2').val(parse.lastName2);
                    $('#registersexo').val(parse.sex);
                    $("#registerMunicipio").val(parse.municipio);
                    $('#birthDayDay').val(parse.birthday.day);
                    $('#birthDayMonth').val(parse.birthday.year);
                    $('#birthDayYear').val(parse.birthday.month);
                    $('#filial1Name').val(filial1.name);
                    $('#filial1LastName1').val(filial1.lastName1);
                    $('#filial1LastName2').val(filial1.lastName2);
                    $('#filial1Curp').val(filial1.curp);
                    $('#filial1Sexo').val(filial1.sex);
                    $('#filial1Country').val(filial1.country);
                    $('#filial2Name').val(filial2.name);
                    $('#filial2LastName1').val(filial2.lastName1);
                    $('#filial2LastName2').val(filial2.lastName2);
                    $('#filial2Curp').val(filial2.curp);
                    $('#filial2Sexo').val(filial2.sex);
                    $('#filial2Country').val(filial2.country);
                    $('#certificateNumber').val(parse.cerificationNumber);
                    $('#registerDate').val(parse.anoRegistro);
                    $('#book').val(parse.book);
                    $('#actaNumber').val(parse.actaNumber);
                    $('#oficialia').val(parse.oficialia);
                    $('#identifierElectronic').val(parse.electronicIdentiier);
                    $('#registerDay').val(parse.registerDate.day);
                    $('#registerMonth').val(parse.registerDate.month);
                    $('#registerYear').val(parse.registerDate.year);
                }
            });
        }
    }
}

// async search
$('#inputSearch').on('input', function () {
    setTimeout(function () {

        curp = $('#inputSearch').val();

        $.ajax({
            url: 'search_curps.php',
            type: 'POST',
            data: {
                curp: curp,
            },
            success: function (resultado) {
                $('#searchResults').html(resultado);
            }

        });
    }, 1000);
});