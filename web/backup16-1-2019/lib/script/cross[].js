var $iframe = $('#frameCross');
var cross_src = "";
if (DATA.zone != 'C')
{
    cross_src = '/CrossSectionService/CrossSectionService.svc/SVGService/GetFloodGate?stnCode=' + stn + '&wlUp=' + DATA.data.wl_up.value.now + '&wlDown=' +DATA.data.wl_down.value.now + '&wlUpH=' + DATA.data.wl_up.value.warning + '&wlUpHH=' + DATA.data.wl_up.value.danger + '&wlDownH=' + DATA.data.wl_down.value.warning + '&wlDownHH=' + DATA.data.wl_down.value.danger;
}
else
{
    cross_src = '/CrossSectionService/CrossSectionService.svc/SVGService/GetPavement?stnCode=' + stn + '&wl=' + DATA.data.wl_up.value.now + '&wlH=' + DATA.data.wl_up.value.warning + '&wlHH=' + DATA.data.wl_up.value.danger;
}
//$iframe.attr('src', cross_src);
$('#svgfile').load(cross_src, function(){
    console.log($('#cross-svg'));
    var eventsHandler;
    eventsHandler = {
      haltEventListeners: ['touchstart', 'touchend', 'touchmove', 'touchleave', 'touchcancel']
    , init: function(options) {
        var instance = options.instance
          , initialScale = 1
          , pannedX = 0
          , pannedY = 0

        // Init Hammer
        // Listen only for pointer and touch events
        this.hammer = Hammer(options.svgElement, {
          inputClass: Hammer.SUPPORT_POINTER_EVENTS ? Hammer.PointerEventInput : Hammer.TouchInput
        })

        // Enable pinch
        this.hammer.get('pinch').set({enable: true})

        // Handle double tap
        this.hammer.on('doubletap', function(ev){
          instance.zoomIn()
        })

        // Handle pan
        this.hammer.on('pan panstart panend', function(ev){
          // On pan start reset panned variables
          if (ev.type === 'panstart') {
            pannedX = 0
            pannedY = 0
          }

          // Pan only the difference
          if (ev.type === 'pan' || ev.type === 'panend') {
            console.log('p')
            instance.panBy({x: ev.deltaX - pannedX, y: ev.deltaY - pannedY})
            pannedX = ev.deltaX
            pannedY = ev.deltaY
          }
        })

        // Handle pinch
        this.hammer.on('pinch pinchstart pinchend', function(ev){
          // On pinch start remember initial zoom
          if (ev.type === 'pinchstart') {
            initialScale = instance.getZoom()
            instance.zoom(initialScale * ev.scale)
          }

          // On pinch zoom
          if (ev.type === 'pinch' || ev.type === 'pinchend') {
            instance.zoom(initialScale * ev.scale)
          }
        })

        // Prevent moving the page on some devices when panning over SVG
        options.svgElement.addEventListener('touchmove', function(e){ e.preventDefault(); });
      }

    , destroy: function(){
        this.hammer.destroy()
      }
    }

    // Expose to window namespace for testing purposes
    window.panZoom = svgPanZoom('#cross-svg', {
      zoomEnabled: true
    , controlIconsEnabled: true
    , fit: 1
    , center: 1
    , customEventsHandler: eventsHandler
    });
}); 