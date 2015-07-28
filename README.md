EventHubBundle
===================


EventHubBundle is an EventBundle integration bundle for Symfony.

It gives you the possibilty to declare events to listen to via your symfony config and configure downstream events to fire like so:

    event_hub:
	    order.create:               #business event
	        mail:                   
	            Valid: 'ORDER_CONFIRMATION'
	        flash:                  
	            Valid:
	                level: success
	                code: 'MSG_ORDER_AJOUT_OK'
	            Invalid:
	                level: danger
	                code: 'MSG_ORDER_AJOUT_KO'
	            Pending:
	                code: 'MSG_ORDER_AJOUT_ATTENTE'

In this example, when the custom "order.create" event is fired, depending on the status of the event, a mail and/or a flash message will be triggered (with the corresponding parameters). The aftermath is way less dependencies between business and application logic.

 NB: Some dependencies are required in order to catch the fired events. see FlashMessageHandlerBundle for Example
