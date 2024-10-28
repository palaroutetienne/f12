function RAZParam()
{
    $('input[name="registre"]:checked', '#formHauteur');
    $('input[name="ambitus"]:checked', '#formHauteur');
    $('input[name="cycle"]:checked', '#formHauteur');

    $('input[name="registre"][value="4"]').prop('checked', true);
    $('input[name="ambitus"][value="0"]').prop('checked', true);
    $('input[name="cycle"][value="a"]').prop('checked', true);

}