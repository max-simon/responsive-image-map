jQuery(document).ready(function(e) {
  jQuery('img[usemap]').rwdImageMaps();
  function show(ev) {
    var rim_id = this.getAttribute('data-rim-id');
   var pic_id = this.getAttribute('data-pic-id');
   document.getElementById('rim-'+rim_id+'-'+pic_id).classList.add('active');
   return false;
  }
  function hide(ev) {
   var rim_id = this.getAttribute('data-rim-id');
   var pic_id = this.getAttribute('data-pic-id');
   document.getElementById('rim-'+rim_id+'-'+pic_id).classList.remove('active');
   return false;
  }
  var maps = document.querySelectorAll('.resp-img-map-container');
  for(var i = 0; i < maps.length; i++) {
    var areas = maps[i].querySelectorAll('area');
    for (var j = 0; j < areas.length; j++) {
     if (areas[j].addEventListener) {
       console.log("hery");
       areas[j].addEventListener('mouseenter', show, false);
       //areas[j].addEventListener('touchstart', show, false);
       areas[j].addEventListener('mouseleave', hide, false);
       //areas[j].addEventListener('touchend', hide, false);
     }
    }
  }
});
