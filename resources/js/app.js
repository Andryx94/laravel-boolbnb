$(document).ready(function() {

  require('./bootstrap');
  var Handlebars = require("handlebars");
  var places = require('places.js');

  //--------------inizializzazione libreria Places.js--------------//
  var placesAutocomplete = places({
    appId: angoliaId,
    apiKey: angoliaKey,
    container: document.querySelector('.address-input'),
  }).configure({hitsPerPage: 5});
  //--------------fine inizializzazione libreria Places.js--------------//

  // var baseUrl = 'http://127.0.0.1:8000/';
  var baseUrl = 'http://localhost:8888/laravel-boolbnb/public/';

  // Homepage
  if(window.location.href == baseUrl) {
    //ottengo coordinate tramite Algolia
    getLatLng(placesAutocomplete);
  }

  // pannello di controllo Admin
  if( window.location.href.includes(baseUrl + "admin/apartments/") ) {
    getLatLng(placesAutocomplete);
  }

  //----------------------------ricerca appartamento----------------------------\\
  var rooms = $('.rooms').val();
  var beds = $('.beds').val();

  // pagina di ricerca appartamenti
  if( window.location.href.includes(baseUrl + "apartments?_method=GET&search=") ) {
    //ottengo coordinate inserite nella Homepage
    var latitude = $('.lat').val();
    var longitude = $('.lng').val();

    getLatLng(placesAutocomplete);

    //chiamata ajax alla api "apartments" proprietaria
    $.ajax(
      {
        url: baseUrl + "api/apartments",
        method: "GET",
        success: function (data_response) {
          //container vuoto
          $(".apartments-list").html("");

          //tutti gli appartamenti ottenuti con la chiamata
          var apartments = data_response.apartments;

          //raggio impostato
          var radius = $('.radius').val();

          //ordino i risultati in base alla distanza crescente
          var sortedApartments = sortByDistance(apartments);

          //handlebars
          displayResults(sortedApartments, radius, rooms, beds);

          //mostro solo appartamenti sponsorizzati pertinenti alla ricerca
          var apartmentSponsorship = $('.apartment-sponsorship');
          filterSponsorshipped(apartmentSponsorship);

          //svuoto gli input
          clearInputs();

          //alterno la visiiblitá degli appartamenti in base ai servizi selezionati
          multiToggle();

        },
        error: function () {
          alert("ERRORE");
        }
      }
    );
  }


  //---------------------------- + ----------- + ----------------------------\\
  //                             |  FUNCTIONS  |                             \\
  //---------------------------- + ----------- + ----------------------------\\

  function clearInputs() {
    // $( ".rooms" ).val( "" );
    // $( ".beds" ).val( "" );
    // $( ".radius" ).val( "" );
    $( ".service-name" ).prop( "checked", false );
  }


  // Formula Haversine (distanza tra due coordinate)
  function getDistance(lat1, lon1, lat2, lon2) {
    var R = 6371; // km
    var dLat = toRad(lat2-lat1);
    var dLon = toRad(lon2-lon1);
    var lat1 = toRad(lat1);
    var lat2 = toRad(lat2);
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.sin(dLon/2) * Math.sin(dLon/2) *
            Math.cos(lat1) * Math.cos(lat2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = R * c;
    return d;
  };

  // gradi in radianti
  function toRad(Value) {
    return Value * Math.PI / 180;
  };

  // ottengo coordinate
  function getLatLng(placesAutocomplete) {
    placesAutocomplete.on('change', function resultSelected(e) {
      var myVal = e.suggestion.latlng;
      var latitude = myVal.lat;   //global variable
      var longitude = myVal.lng;  //global variable
      $('.lat').val(latitude);
      $('.lng').val(longitude);
    });
  };

  // ordino per distanza gli appartamenti ottenuti con la chiamata ajax
  function sortByDistance(apartmentsTable) {
    var arr = [];

    for (var i = 0; i < apartmentsTable.length; i++) {
      var thisLat = apartmentsTable[i].lat;
      var thisLng = apartmentsTable[i].lng;
      var thisApartments = apartmentsTable[i];
      var distance = getDistance(latitude,longitude,thisLat,thisLng);
      var geolocApartment =
      {
        "apartment" : thisApartments,
        "distance" : distance
      };

      arr.push(geolocApartment);
    }

    arr.sort((a, b) => {
      return a.distance - b.distance;
    });

    var sortedArr = [];

    for (var i = 0; i < arr.length; i++) {
      var apartment = arr[i].apartment;
      sortedArr.push(apartment);
    }

    return sortedArr;
  };


  // stampo i risultati della ricerca
  function displayResults(apartments, radius, rooms, beds) {
    var template = $('#handlebars').html();
    var templateScript = Handlebars.compile(template);

    for (var i = 0; i < apartments.length; i++) {
      //geolocalizzazione
      var thisLat = apartments[i].lat;
      var thisLng = apartments[i].lng;
      var distance = getDistance(latitude,longitude,thisLat,thisLng);
      distance = parseInt(distance);

      //store delle immagini
      var mainImage = apartments[i].img_main_path;
      var services = apartments[i].services;


      //se l'annuncio è attivo
      if (apartments[i].visible === 1) {
        //se non supera il raggio settato
        if (distance <= radius) {
          //se numero letti e stanze è pari al valore settato
          if ((rooms != "") ? (apartments[i].rooms != "" && apartments[i].rooms >= rooms) : true) {
            if ((beds != "") ? (apartments[i].beds != "" && apartments[i].beds >= beds) : true) {
              //scelta img
              if (mainImage !== '/img/imgDefault.jpg') {
                mainImage = baseUrl + 'storage/' + mainImage;
              } else {
                mainImage = baseUrl + 'img/imgDefault.jpg';
              }

              //template
              var context = {
                 "id" : baseUrl + "apartments/" + apartments[i].id,
                 "title" : apartments[i].title,
                 "address" : apartments[i].address,
                 "city" : apartments[i].city,
                 "img_main_path" : mainImage,
                 "distance" : distance,
                 "services" : services
               };

              var html = templateScript(context);
              $('.apartments-list').append(html);
            }
          }
        }
      }
    }
  };


  // filtra gli appartamenti sponsorizzati per distanza
  function filterSponsorshipped(apartmentSponsorship) {
    $(apartmentSponsorship).each(function() {
      var latitude = $('.lat').val();
      var longitude = $('.lng').val();
      var radius = $('.radius').val();
      var distance = getDistance(latitude, longitude, $(this).attr('data-lat'), $(this).attr('data-lng'));
      if (radius <= distance) {
        $(this).parent().hide();
      }
    });
  };


  // stessi elementi e stesso numero di elementi
  function sameArray(arr1, arr2) {
    if ($(arr1).not(arr2).length === 0 && $(arr2).not(arr1).length === 0) {
      return true;
    }
    return false;
  };

  // torna true se tutti gli elementi di un array sono contenuti nell'altro, altrimenti false
  function ifIncludesAll(arr, arr2) {
    return arr.every(i => arr2.includes(i));
  };

  // compara l'array dei servizi scelti dall'utente
  // con gli array dei servizi posseduti da ciascun appartamento
  function multiToggle() {
    $(".service-name:checkbox").click(function () {
      var isFlagged = $(this).is(":checked");

      //eveto CHECK
      if (isFlagged) {

        //ad ogni check creo un array arr di servizi checked
        //arr rappresenta quindi l' array dei servizi selezionati
        var arr = [];
        var thisService = $(this);
        var thisServiceName = thisService.attr('data-service-name');
        arr.push(thisServiceName);
        var thoseOthers = thisService.parent().siblings().children('.service-name');
        $( thoseOthers ).each(function() {
          if ($(this).is(':checked')) {
            var thoseOthersCheckedServicesName = $(this).attr('data-service-name');
            arr.push(thoseOthersCheckedServicesName);
          }
        });

        //ciclo in ogni appartamento indicizzato
        //per leggere quali sono i servizi offerti
        var apartments = $('.apartments-list');
        var apartment = $('.apartment');
        $( apartments ).each(function() {
          $( apartment ).each(function() {

            var themAttr = $(this).attr('data-services');
            //splittedThemAttr rappresenta ciascun array dei servizi disponibili in ogni appartamento
            var splittedThemAttr = themAttr.split(',');

            //ciclo for per comparare i servizi disponibili [splittedThemAttr]
            //con i servizi selezionati [arr]
            for (var i = 0; i < arr.length; i++) {
              if ( ( splittedThemAttr.length === arr.length ) ) {
                if ( sameArray(arr, splittedThemAttr) ) {

                    $(this).show("fast");

                } else {

                    $(this).hide("fast");

                }

              } else if ( splittedThemAttr.length < arr.length ) {

                  $(this).hide("fast");

              } else if ( splittedThemAttr.length > arr.length )  {
                if ( ifIncludesAll(arr, splittedThemAttr) ) {

                    $(this).show("fast");

                } else {

                    $(this).hide("fast");

                }
              }
            }
          });
        });

        console.log(arr); // array di tutti i servizi checked

        //eveto UNCHECK
      } else {

        //arr2 rappresenta l'array dei soli servizi selezionati
        var arr2 = [];
        var uncheckedOne = $(this);
        var othersUnchecked = uncheckedOne.parent().siblings().children('.service-name');
        $(othersUnchecked).each(function() {
          var othersUncheckedName = $(this).attr('data-service-name');
          if ($(this).is(':checked')) {
            arr2.push(othersUncheckedName);
          }
        });

        console.log(arr2); // array dei soli servizi checked

        var apartments = $('.apartments-list');
        var apartment = $('.apartment');
        //prima mostro tutto poi ripeto le operazioni che eseguo al check
        apartment.show(100, 'linear');

        $( apartments ).each(function() {
          $( apartment ).each(function() {

            var themAttr = $(this).attr('data-services');
            var splittedThemAttr = themAttr.split(',');

            for (var i = 0; i < arr2.length; i++) {
              if ( ( splittedThemAttr.length === arr2.length ) ) {
                if ( sameArray(arr2, splittedThemAttr) ) {

                    $(this).show("fast");

                } else {

                    $(this).hide("fast");

                }

              } else if ( splittedThemAttr.length < arr2.length ) {

                  $(this).hide("fast");

              } else if ( splittedThemAttr.length > arr2.length )  {
                if ( ifIncludesAll(arr2, splittedThemAttr) ) {

                    $(this).show("fast");

                } else {

                    $(this).hide("fast");

                }
              }
            }
          });
        });
      }

    });

  };

}); //end ready
