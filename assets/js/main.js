const btnsDelete = document.querySelectorAll('td button.botao-excluir');
const btnsEdit = document.querySelectorAll('td button.botao-editar');
const btnModal = document.getElementById('btn-modal-sim');
const btnModalEdit = document.getElementById('btn-modal-edit');

const myModal = new bootstrap.Modal('#exampleModal', {
  keyboard: false
});

const myModalEdit = new bootstrap.Modal('#editModal', {
  keyboard: false
});

let userId = null;
btnsDelete.forEach(function (element) {
  element.addEventListener('click', function (e) {
    userId = element.id;
  });
});

btnsEdit.forEach(function (element) {
  element.addEventListener('click', function (e) {
    userId = element.id;
    carregaModal(userId);
  });
});

// Botão sim do modal deletar
btnModal.addEventListener('click', function (e) {
  // Aqui chamada para arquivo php
  axios.get(`${location.origin}/adm/deletar.php?userId=${userId}`)
    .then(function (response) {
      // manipula o sucesso da requisição
      if (response.data.sucess === true) {
        myModal.hide();
        const linha = document.getElementById(`tr-${userId}`);
        linha.parentNode.removeChild(linha);

      } else {
        alert('Não foi possivel deletar! Entre em contato com o desenvolvedor');
      }

    })
    .catch(function (error) {
      // manipula erros da requisição
      alert('Não foi possivel deletar! Entre em contato com o desenvolvedor');
      console.log(error);
    });
});

// Botão salvar do modal editar
btnModalEdit.addEventListener('click', function (e) {

  const id = document.getElementById('formId').value;
  const nome = document.getElementById('formNome').value;
  const ramal = document.getElementById('formRamal').value;
  const unidade = document.getElementById('formUnidade').value;
  const setor = document.getElementById('formSetor').value;

  axios.get(`${location.origin}/adm/editar.php`, {
    params: {
      id: id,
      nome: nome,
      ramal: ramal,
      unidade: unidade,
      setor: setor
    }
  })
    .then(function (response) {

      if (response.data.sucess === true) {

        myModalEdit.hide();
        location.reload();

      } else {
        alert('Ramal em uso!');
      }

    })
    .catch(function (error) {
      console.error(error);
    });

});


function carregaModal(userId) {

  axios.get(`${location.origin}/adm/getById.php?userId=${userId}`)
    .then(function (response) {
      // manipula o sucesso da requisição
      const id = document.getElementById('formId');
      const nome = document.getElementById('formNome');
      const ramal = document.getElementById('formRamal');
      const unidade = document.getElementById('formUnidade');
      const setor = document.getElementById('formSetor');

      id.value = response.data.id;
      nome.value = response.data.nome;
      ramal.value = response.data.ramal;
      unidade.value = response.data.unidade;
      setor.value = response.data.setor;

    })
    .catch(function (error) {
      // manipula erros da requisição
      alert('Não foi possivel deletar! Entre em contato com o desenvolvedor');
      console.log(error);
    });
};
