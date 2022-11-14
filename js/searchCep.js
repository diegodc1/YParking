function limpa_formulário_cep() {
  document.getElementById('inputRoad').value = ''
  document.getElementById('inputDistrict').value = ''
  document.getElementById('inputCity').value = ''
  document.getElementById('inputState').value = ''
  // document.getElementById('inputZipCode').classList.remove('error-cep')
  // document.getElementById('message-cep-error').style.display = 'none'
  // document.getElementById('ibge').value = ''
}

function meu_callback(conteudo) {
  if (!('erro' in conteudo)) {
    //Atualiza os campos com os valores.
    document.getElementById('inputZipCode').classList.remove('error-cep')
    document.getElementById('message-cep-error').style.display = 'none'
    document.getElementById('inputRoad').value = conteudo.logradouro
    document.getElementById('inputDistrict').value = conteudo.bairro
    document.getElementById('inputCity').value = conteudo.localidade
    document.getElementById('inputState').value = conteudo.uf
    document.getElementById('continue-button').disabled = false
    // document.getElementById('ibge').value = conteudo.ibge
  } else {
    //CEP não Encontrado.
    limpa_formulário_cep()
    document.getElementById('inputZipCode').classList.add('error-cep')
    document.getElementById('message-cep-error').style.display = 'flex'
    document.getElementById('continue-button').disabled = true
  }
}

function pesquisacep(valor) {
  var cep = valor.replace(/\D/g, '')

  //Verifica se campo cep possui valor informado.
  if (cep != '') {
    var validacep = /^[0-9]{8}$/

    //Valida o formato do CEP.
    if (validacep.test(cep)) {
      //Preenche os campos com "..." enquanto consulta webservice.
      document.getElementById('inputZipCode').classList.remove('error-cep')
      document.getElementById('message-cep-error').style.display = 'none'
      document.getElementById('inputRoad').value = '...'
      document.getElementById('inputDistrict').value = '...'
      document.getElementById('inputCity').value = '...'
      document.getElementById('inputState').value = '...'
      document.getElementById('continue-button').disabled = false
      // document.getElementById('ibge').value = '...'

      var script = document.createElement('script')
      script.src =
        'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback'

      document.body.appendChild(script)
    } else {
      //cep é inválido.
      document.getElementById('inputZipCode').classList.add('error-cep')
      document.getElementById('message-cep-error').style.display = 'flex'
      document.getElementById('continue-button').disabled = true
      limpa_formulário_cep()
    }
  } else {
    limpa_formulário_cep()
  }
}
