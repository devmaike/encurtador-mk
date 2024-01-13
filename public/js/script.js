$('#submit').click(function () {
  var original_url = $('.input-url').val();
  if (original_url.indexOf('http://') == 0 || original_url.indexOf('https://') == 0) {
    submit();
  } else {
    alert('URL inválida. Use http:// ou https://');
    return false;
  }
});

$('#copy').click(function () {
  var copyText = document.getElementById("url_short");
  copyText.select();

  try {
    var successful = document.execCommand('copy');
    if (successful) {
      $('#copy').text('Copiado').css('background-color', '#4CAF50');
      $('#copy').css('color', '#fff');
    } else {
      $('#copy').text('Falha ao Copiar').css('background-color', '#FF0000');
    }
    setTimeout(function () {
      $('#copy').text('Copiar URL').css('background-color', '#ffffff');
      $('#copy').css('color', '#495057');
      $('#copy').css('border', '1px solid #ced4da');

    }, 3000);
  } catch (err) {
    console.error('Erro ao copiar o texto: ', err);
    $('#copy').text('Falha ao Copiar').css('background-color', '#FF0000');
  }
});
