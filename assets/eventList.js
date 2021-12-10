



function loadEvents(page) {
    $.getJSON( "/api/events", { page: page} )
    .done(function( data ) {
      data.forEach(event => {
          var element = $(`<div class="col-3">
      <div class="card">
        <img src="/images/js.png" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">`+ event.name + `</h5>
          <p class="card-text">`+ event.owner.firstname + " " + event.owner.lastname + `</p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Start: `+ event.startAt + `</li>
          <li class="list-group-item">End: `+ event.endAt + `</li>
  
        </ul>
        <div class="card-body">
          <a href="/event/show/`+ event.id + `" class="card-link">Show Event</a>
        </div>
      </div>
    </div>`);
  
          $("#event_list").append(element);
          
  
      });
      pagenum++;
      console.log(data);
    })

}
var pagenum = 1;
loadEvents(pagenum);
$("#loadMore").on('click', function () {
 loadEvents(pagenum);
});

