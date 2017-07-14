window.addEvent('domready', function(){
	

    //create our Accordion instance
    var myAccordion = new Fx.Accordion(document.id('accordionMooToolsAccessible'), 'h3.togglerAccordionMooToolsAccessible', 'div.elementAccordionMooToolsAccessible', {
        opacity: false,
        onActive: function(togglerAccordionMooToolsAccessible, elementAccordionMooToolsAccessible){
            togglerAccordionMooToolsAccessible.addClass('active');
        },
        onBackground: function(togglerAccordionMooToolsAccessible, elementAccordionMooToolsAccessible){            
            togglerAccordionMooToolsAccessible.removeClass('active');
        }
    });
});
