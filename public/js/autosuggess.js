$(document).ready(function(){
      $('#autosuggess-query').typeahead({
          minLength: 1,
          order: "asc",
          dynamic: true,
          delay: 100,
          backdrop: {
              "background-color": "#fff"
          },
          template: '<span class="row">' +
              '<span class="avatar">' +
                  '<img src="{{image}}">' +
              "</span>" +
              '<span class="date pull-right">({{brand}})</span>' +
              '<span class="name">{{name}}<small class="pull-right" style="color: #777">{{type}}</small></span>'+
          "</span>",
          source: {
              product: {
                  display: "name",
                  data: [],
                  url: [{
                      ttype: "GET",
                      url: "/collection/autosuggessProduct",
                      data: {
                          search: "{{query}}"
                      }, 
                      callback: {
                          done: function (data) {                        
                              return data;
                          }
                      }
                  }, "data.product"]
              }       
          },
          callback: {
              onClick: function (node, a, item, event) {
                 var product_id = item.id;
                 $.ajax({
                    type: "POST",
                    data : {
                      _token : token,
                      product_id: product_id,
                      collection_id: collection_id
                    },
                    url: '/collection/storeProduct'
                  }).done(function( rels ) {
                    if (rels.status == '0') {
                      alert('Add error');
                      console.log(rels);
                    } else {
                      $('#datatable-icons').DataTable().ajax.reload();
                    }                    
                  });

              }
          },
          debug: true
      });
});