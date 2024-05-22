# Artefactes d'scrum que han de quedar documentats.
  ## Sprint plan semanal 
  ### L'idea general del projecte
    App de xarxa social de vida nocturna arreu del món, centrat en discoteques.
    Per a obsolir això, es necessiten usuaris, fet que dona lloc a autorització de clients a l'applicació, es necessiten locals, en el nostre cas discoteques, amb informació sobre les mateixes i finalment, interacció entre els clients, com podrien ser chats o fòrums on els usuaris puguin comunicar-se.
    
    Una vegada es va tenir l'idea, es segueix i es formulen funcionalitats seguint aquest model: 
    Com a usuari vull poder fer X.

    Aplicant el model al projecte, es creen les idees de funcionalitats així: 
    Com a usuari vull poder comunicar-me amb altres usuaris.
    Com a usuari vull veure informació sobre els diferents locals.
    ...
  
  ## Retrospectiva

  ### Seguiments dels SPRINTs
  #### SPRINT 1
    Hi van haver complicacions per a fer sorgir l'idea del projecte, i tot i que finalment acaba sorgint, no s'entén del tot de que està composa, així que, tot i que va haver-hi una direcció, la direcció del grup va ser foscosa.
    No va ser fins molt després *SPRINT 3* on el grup va decidir executar la seva direcció cap un enllaç més entrellaçat amb allò relacionat amb xarxes socials.

    Més enllà de les complicacions, es comença a crear un mapa interactuable amb els diferents locals de l'aplicació, es creen fitxes dels mateixos per a mostrar quan un usuari interactua amb els punts del mapa *els locals* i es fan avanços i preparacions per a els futurs requeriments en relació a la base de dades: es preparen les taules d'usuaris, de categories dels locals...
    
  #### SPRINT 2
    S'inicia les funcionalitats dels usuaris, autorització dels mateixos, editació de perfil *canvis de nom, etc*, es crea un carrusel i galeria de locals *tots dos descartats* funcional per a mostrar els diferents locals a un altra vista més detallada i de forma més visual.

  #### SPRINT 3
    Funcionalitats d'admin per les taules d'usuaris, locals *discoteques*, entre altres i models d'interfície per a la part social i personal de l'aplicació: chats, llista amics, editació de perfil, segment de privadesa...
  
  #### SPRINT 4
    S'inicia la implementació del chat entre usuaris, avanços visuals i fixades d'errors en les diferents vistes de l'app: crear review, mostrar review, portada, login, register...
    S'inicia la implementació dels inTimes, instantànis dels moments tinguts del usuari a una discoteca. D'aquesta manera, els usuaris poden veure entre ells mateixos que està fent o estava fent cadascú.
    Els inTimes generen una notificació, la qual porta a una simple i bàsica pàgina amb tres botons, un botó per la foto delantera, un altre per la trasera i finalment un per enviar.

    Es crea un filtre dels locals per ciutats *només fet per Espanya*.

  #### SPRINT 5
    Relacions entre usuaris esmentades a la base de dades: Els usuaris es poden seguir entre ells mateixos, si dos usuaris es segueixen mutuament, es consideren amics.
    Amb la creació d'amics, el chat entre usuaris avança, es veuen tots els amics dels usuaris i es creen salas per comunicar-se entre algú. *El chat deixa de ser una comunicació entre dos persones qualsevols*.

    S'afegeixen comentaris als inTimes, aquells instantànis de moments pasats a algun dels locals.

    Fixada d'errors i avanços visuals en la part d'usuaris a les funcionalitats de login, register, editació de perfil. A més de la portada.
  
  #### SPRINT 6
    Acabar visualment el chat, els inTimes junt fixades d'errors i augments visuals a la part de resenyes, tan crear resenya com mostrar resenyes.

  ### Valoració de l'evolució del grup
    Durant el transcurs del projecte, el grup ha experimentat diversos canvis i reptes que han influït en la seva evolució i dinàmica de treball.

    Inicialment, el grup va enfrontar dificultats en la comprensió i definició clara de l'enfocament del projecte, la qual cosa va resultar en una manca de cohesió i direcció clara. Això es va reflectir en els primers SPRINTS del taiga, on les tasques van ser reconsiderades i, en alguns casos, rebutjades, provocant una certa desorientació i desmotivació en el grup.

    A mesura que es van superar els obstacles inicials i es va establir una direcció més clara, el grup va mostrar una millora.

    Alguns han fet o només han fet la part visual, altres només han fet part backend i part frontend, altres han fet de tot.


  ### Valoració de l'evolució del projecte 
    Els primers SPRINTS (1-3) del projecte van presentar dificultats en la definició de l'enfocament, i es va veure la necessitat de fer canvis significatius. L'ús de tecnologies com STRAPI, l'implementació del carrusel i la galeria, el disseny de la portada i l'ús de Leaflet per al mapa interactiu van ser reconsiderats i finalment rebutjats. Això va conduir a un canvi d'estratègia cap a un enfocament més centrat en la part social de l'aplicació.

    Com a resultat, es va prendre la decisió de reorientar el projecte per centrar-se exclusivament en el desenvolupament d'una aplicació mòbil. Aquest canvi va permetre concentrar els esforços en les funcionalitats socials de l'aplicació, com ara els xats entre usuaris, la gestió d'amistats i altres funcionalitats relacionades amb la interacció social.

    Aquesta adaptació de l'enfocament va permetre un progrés més coherent i va evitar la dispersió dels recursos del projecte. Tot i les complicacions inicials, aquesta redefinició ha portat a un enfocament més clar i concentrat en les necessitats dels usuaris, contribuint a una millora en la direcció i la eficiència del desenvolupament del projecte.


  

