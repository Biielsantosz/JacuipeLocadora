function searchCatalog() {
  // Obter o valor digitado no campo de busca
  const searchTerm = document.querySelector('.search-input').value.toLowerCase();
  
  // Obter todos os itens do catálogo
  const catalogItems = document.querySelectorAll('.card-item');

  // Iterar sobre cada item do catálogo
  catalogItems.forEach(item => {
    // Obter o nome do modelo de cada item
    const modelName = item.getAttribute('data-name').toLowerCase();

    // Verificar se o nome do modelo contém o texto da pesquisa
    if (modelName.includes(searchTerm)) {
      item.style.display = ''; // Mostrar o item
    } else {
      item.style.display = 'none'; // Esconder o item
    }
  });
}
