// // @author > Vítor Hugo Mendes
// // @since 26/11/2024        


// /*  ============================ 
//          SEÇÃO: API DO GOOGLE MAPS
//    ============================ */



// // Estilos personalizados para o mapa
const mapStyles = [
    // Seus estilos personalizados do mapa (se desejado)
];

// Função para inicializar o mapa
window.onload = function() {
    initMap(); } // Chama a função manualmente após o carregamento da página
const mapOptions = {
    zoom: 16,
    center: { lat: -19.324020, lng: -48.912893 }, // Alterar para a sua localização
    mapTypeId: 'roadmap',
    styles: mapStyles,
};

    // Criando o mapa
    const map = new google.maps.Map(document.getElementById("map"), mapOptions);

    // Criando um marcador no mapa
    const marker = new google.maps.Marker({
        position: { lat: -19.324020, lng: -48.912893 },
        map: map,
        title: "Nossa localização",
    });



