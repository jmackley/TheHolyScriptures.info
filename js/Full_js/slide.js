//--horizontal
window.addEvent('domready', function() {
	// HERE IS WHAT YOU READ IN JS CODE
  var mySlide2 = new Fx.Slide('test2', {mode: 'horizontal'});
   
  $('slidein2').addEvent('click', function(e){
    e = new Event(e);
    mySlide2.slideIn();
    e.stop();
  });
   
  $('slideout2').addEvent('click', function(e){
    e = new Event(e);
    mySlide2.slideOut();
    e.stop();
  });
   
  $('toggle2').addEvent('click', function(e){
    e = new Event(e);
    mySlide2.toggle();
    e.stop();
  });
   
  $('hide2').addEvent('click', function(e){
    e = new Event(e);
    mySlide2.hide();
    e.stop();
  });

}); 
