# SCRUM
## Sprint plan semanal 
### L'idea general del projecte

Per crear una aplicació de xarxa social centrada en la vida nocturna, especialment en discoteques a tot el món, hem de considerar diverses necessitats clau.

Primer de tot, és imprescindible aconseguir una base d'usuaris activa. Això requereix una autenticació segura dels clients a l'aplicació, proporcionant-los una experiència fiable i segura.

En segon lloc, és vital col·laborar amb locals, especialment discoteques, per obtenir informació actualitzada sobre els mateixos, com ara ubicació, horaris d'obertura, promocions i esdeveniments especials.

Finalment, és crucial facilitar la interacció entre els usuaris per fomentar l'engagement i la comunitat. Això pot incloure funcionalitats com xats en temps real, fòrums de discussió temàtics, i compartir contingut relacionat amb les experiències de la vida nocturna.

Un cop s'ha concebut la idea principal, es pot seguir un model estructurat per formular les funcionalitats de l'aplicació, com ara:

- Com a usuari, vull poder comunicar-me amb altres usuaris per compartir experiències i recomanacions.
- Com a usuari, vull tenir accés a informació detallada sobre les diferents discoteques, incloent-hi ubicació, horaris i valoracions dels clients.
Com a usuari, vull rebre notificacions sobre esdeveniments especials i promocions de les discoteques.
- Com a usuari, vull poder guardar els meus llocs preferits i accedir-hi fàcilment.
- Com a usuari, vull compartir fotos i vídeos de les meves experiències a les discoteques amb altres membres de la comunitat.
- Com a usuari, vull tenir la possibilitat de deixar valoracions i comentaris sobre les discoteques que he visitat.
- Com a usuari, vull poder seguir altres usuaris per estar al corrent de les seves activitats i recomanacions.
Aquestes funcionalitats formen la base d'una aplicació de xarxa social de vida nocturna que pot proporcionar una experiència enriquidora i comunitària als seus usuaris.
  
## Retrospectiva

### Seguiments dels SPRINTs
#### SPRINT 1

Al principi hi va haver algunes complicacions per definir clarament la idea del projecte, i fins i tot quan l'idea va començar a prendre forma, la seva composició no era del tot clara. Això va portar a una certa manca de claredat en la direcció del grup.

No va ser fins molt més endavant, concretament després del SPRINT 3, que el grup va decidir orientar-se cap a una direcció més alineada amb les xarxes socials.

Malgrat les dificultats, es van realitzar progressos significatius. Es va començar a desenvolupar un mapa interactiu que mostrava els diferents locals de l'aplicació, així com a crear fitxes informatives per a cada local per tal de proporcionar una millor experiència d'usuari. A més, es van realitzar preparatius per a futurs requeriments relacionats amb la base de dades, com la creació de taules per a usuaris i categories de locals. Aquests avanços van marcar un punt d'inflexió en el desenvolupament del projecte, obrint camí cap a una implementació més estructurada i coherent.
    
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
Durant el transcurs del projecte, el grup ha enfrontat diversos canvis i reptes que han tingut un impacte significatiu en la seva evolució i dinàmica de treball.

Inicialment, el grup va trobar dificultats en comprendre i definir clarament l'enfocament del projecte, la qual cosa va conduir a una manca de cohesió i una direcció no del tot clara. Això es va reflectir en els primers SPRINTS del taiga, on les tasques van ser reconsiderades i, en alguns casos, fins i tot rebutjades, generant una certa desorientació i desmotivació en el grup.

A mesura que es van superar els obstacles inicials i es va establir una direcció més clara, el grup va mostrar una millora palpable.

Alguns membres del grup s'han centrat únicament en la part visual, mentre que altres s'han dedicat exclusivament al backend o al frontend. D'altra banda, alguns han assumit la responsabilitat de totes les àrees del desenvolupament.


  ### Valoració de l'evolució del projecte 
  Els primers SPRINTS (1-3) del projecte van experimentar dificultats en la definició de l'enfocament, el que va requerir canvis significatius. Inicialment, s'havia contemplat l'ús de tecnologies com STRAPI, la implementació del carrusel i la galeria, el disseny de la portada i l'ús de Leaflet per al mapa interactiu. No obstant això, aquests elements van ser reconsiderats i finalment descartats, impulsant un canvi d'estratègia cap a un enfocament més orientat a la dimensió social de l'aplicació.

Com a conseqüència, es va prendre la decisió de reorientar completament el projecte per focalitzar-se exclusivament en el desenvolupament d'una aplicació mòbil. Aquesta modificació va permetre concentrar els esforços en les funcionalitats socials de l'aplicació, com ara els xats entre usuaris, la gestió d'amistats i altres aspectes relacionats amb la interacció social.

Aquesta adaptació de l'enfocament va propiciar un progrés més coherent i va evitar la dispersió dels recursos del projecte. Tot i les dificultats inicials, aquesta redefinició ha suposat un enfocament més nítid i concentrat en les necessitats dels usuaris, contribuint a una millora en la direcció i l'eficiència del desenvolupament del projecte.

## Identificació de problemes
### SOCKETS
#### Autenticació d'usuaris:
Implementar un sistema de autenticació sòlid utilitzant tokens JWT (JSON Web Tokens) o sessions d'usuari per verificar la identitat del client abans de permetre l'accés a les funcions del xat.

#### Validació de dades:
Realitzar una validació exhaustiva de les dades rebudes del client per evitar atacs de tipus XSS (Cross-Site Scripting) o injeccions de codi maliciós. Validar els IDs d'usuari per assegurar-se que corresponen a usuaris legítims i autoritzats per accedir al sistema.

#### Seguretat en el maneig de sockets:
Implementar mesures de seguretat addicionals en el maneig de sales de xat, com comprovacions de permisos per unir-se a una sala específica o limitar les accions que un usuari pot realitzar dins d'una sala. Utilitzar tècniques de xifrat per protegir la comunicació entre el client i el servidor, especialment en entorns on es transmeten dades sensibles.

#### Seguretat en la persistència de dades:
Encriptar els missatges abans d'emmagatzemar-los a la base de dades per protegir la privacitat dels usuaris en cas d'una violació de seguretat. Implementar còpies de seguretat regulars de la base de dades i utilitzar tècniques de hash segures per protegir les contrasenyes i altres dades confidencials.

#### Validació al costat del servidor:
Realitzar validacions addicionals al costat del servidor per evitar atacs d'injecció SQL i altres vulnerabilitats de seguretat.


## Resolució dels problemes dels sockets
#### Autenticació d'usuaris:
Implementar un sistema d'autenticació robust implica validar les credencials de l'usuari, com ara el nom d'usuari i la contrasenya, utilitzant tècniques segures com el xifrat de contrasenyes amb algoritmes com el bcrypt. Un cop l'usuari s'autentica correctament, es pot generar un token JWT que contingui informació sobre la sessió de l'usuari, com ara la seva ID i qualsevol altra dada rellevant. Aquest token s'enviaria al client i s'adjuntaria a totes les sol·licituds posteriors com a forma d'identificació. Al servidor, es verificarà la validesa i la integritat del token en cada sol·licitud per garantir que l'usuari estigui autoritzat per accedir als recursos sol·licitats.

#### Validació de dades:
Per evitar atacs de tipus XSS, cal escapar o filtrar totes les dades d'entrada de l'usuari que es mostren al costat del client per eliminar qualsevol codi maliciós que pugui estar present. Per prevenir injeccions de codi maliciós, cal utilitzar consultes parametritzades o funcions ORM en lloc de construir consultes SQL dinàmiques concatenant cadenes de text amb dades proporcionades per l'usuari. Això assegura que les dades de l'usuari no s'interpretin com a part de la consulta SQL i evita l'execució de comandes no autoritzades a la base de dades.

#### Seguretat en el maneig de sockets:
A més de les validacions d'autenticació, es poden implementar rols d'usuari i permisos específics per limitar les accions que un usuari pot realitzar en el xat, com ara enviar missatges, crear sales o convidar altres usuaris. Per protegir la comunicació entre el client i el servidor, es pot utilitzar HTTPS en lloc de HTTP per xifrar les dades transmeses. A més, es poden implementar protocols de seguretat com TLS (Transport Layer Security) per xifrar la comunicació a nivell de socket.

#### Seguretat en la persistència de dades:
Abans d'emmagatzemar missatges a la base de dades, es poden xifrar utilitzant algoritmes de xifrat sòlids com AES (Advanced Encryption Standard). Això garanteix que els missatges estiguin protegits fins i tot si la base de dades és compromesa. A més, es poden implementar tècniques de hashing segures per emmagatzemar contrasenyes i altres dades confidencials a la base de dades. Això evita que les contrasenyes s'emmagatzemin en text pla i fa que sigui més difícil per a un atacant obtenir accés als comptes dels usuaris fins i tot si la base de dades és compromesa.

#### Validació al costat del servidor:
En realitzar operacions de base de dades, cal utilitzar consultes parametritzades o funcions ORM per evitar la possibilitat d'injecció SQL. Això garanteix que les dades proporcionades per l'usuari s'interpreten només com a valors i no com a part de l'estructura de la consulta SQL. A més, cal realitzar validacions exhaustives al costat del servidor per garantir que les dades proporcionades per l'usuari compleixin certs criteris de seguretat i no continguin dades malicioses o no vàlides que puguin comprometre l'aplicació.



## Idenfificació de problemes al xat
### Autenticació d'usuaris:
Implementar un sistema d'autenticació sòlid utilitzant tokens JWT (JSON Web Tokens) o sessions d'usuari per verificar la identitat del client abans de permetre l'accés a les funcions del xat.

### Validació de dades: 
Realitzar una validació exhaustiva de les dades rebudes del client per evitar atacs de tipus XSS (Cross-Site Scripting) o injeccions de codi maliciós. Validar els IDs d'usuari per assegurar-se que corresponen a usuaris legítims i autoritzats per accedir al sistema.

### Seguretat en el maneig de dades a Redis: 
Implementar mesures de seguretat addicionals en el maneig de missatges emmagatzemats a Redis, com comprovacions de permisos per publicar missatges o accedir a l'historial de missatges. Utilitzar tècniques de xifrat per protegir les dades emmagatzemades i en trànsit.

### Seguretat en la persistència de dades: 
Encriptar els missatges abans d'emmagatzemar-los a Redis per protegir la privacitat dels usuaris en cas d'una violació de seguretat. Implementar còpies de seguretat regulars de les dades emmagatzemades a Redis i utilitzar tècniques de hash segures per protegir les contrasenyes i altres dades confidencials.

### Validació al costat de servidor
Realitzar validacions addicionals al costat del servidor per evitar atacs d'injecció SQL, si s'utilitzen bases de dades addicionals, i altres vulnerabilitats de seguretat.




## Seguidors
### Plantejament del Problema
El funcionament dels seguidors no va assolir les expectatives desitjades; lamentablement, la funcionalitat de seguir usuaris no va ser completament implementada. No es van incorporar actualitzacions o alertes per als inTimes d'altres usuaris seguits, una vista detallada dels teus seguidors amb la possibilitat de navegar als seus perfils personals, o fins i tot la possibilitat de mantenir converses amb els seguidors.

### Possibles Solucions
#### Completar la vista d'un perfil d'usuari dinàmic.
Utilitzant un identificador dinàmic, que es trobi disponible en la vista del perfil personal, cada icona dels teus amics o en una nova vista de seguidors, es mostraria una descripció detallada de cada seguidor. A partir d'aquest identificador, que per raons de seguretat s'hauria d'encriptar a la URL, es realitzaria una sol·licitud al Laravel per obtenir informació com el nom, la imatge de perfil i altres dades rellevants de l'usuari a mostrar. Un cop s'obtingui aquesta informació, es podria afegir un botó de xat per comunicar-se amb el seguidor.

#### Implementar les modificacions necessàries per al xat.
No seria necessari realitzar canvis substancials en el sistema de xat, ja que està dissenyat per a funcionar entre dos usuaris. Es podrien reutilitzar les crides de sockets existents utilitzades per al xat amb amics. La crida en qüestió seria aquella que permet unir-se a una sala de xat amb un usuari concret. Les identificacions dels usuaris es guarden al Pinia un cop inicien sessió, per tant, aquesta informació ja estaria disponible per a les operacions relacionades amb el xa


## Apreciacions
### Descripció del Problema
Durant el desenvolupament de l'aplicació Elysium, vam concebre una plataforma dinàmica amb l'objectiu que els joves poguessin compartir les seves vivències nocturnes, connectar amb amics i descobrir nous indrets per gaudir de la festa. Un dels elements clau que vam considerar essencial per fomentar la interacció i la participació de la comunitat va ser la inclusió de la funció de "likes" en les ressenyes, comentaris i inTimes (berenars) publicats pels usuaris sobre les discoteques.

Aquesta funcionalitat també ens permetria aprofundir en els nostres filtres i prioritzar el contingut més apreciat, ja sigui les ressenyes més valorades de cada discoteca, els posts inTimes més destacats o els comentaris més enginyosos.

Desafortunadament, no es va completar la implementació d'aquesta funcionalitat. Admetent-ho, ens adonem que l'aplicació queda una mica incompleta, ja que aquesta funció és fonamental i habitual en altres aplicacions similars com Snapchat o Instagram.

### Possibles Solucions
La implementació és senzilla: afegir una columna de "likes" a la base de dades de tipus enter a cadascuna de les taules: inTimes, ressenyes i comentaris. A més, integrar botons que enviïn sol·licituds al backend des de la part dels clients al lloc adequat per tal de donar "like" o "dislike": un a cada ressenya, a cada post d'inTime i a cada comentari dels inTimes.


## Altres funcionalitats no implementades
A continuació, es presenta una breu llista de funcionalitats i idees que es volien incorporar, però, a causa de la manca de temps, es van haver de rebutjar per tal de poder avançar amb el projecte.

- Compra d'entrades:
Col·laboració amb discoteques per possibilitar el pagament d'entrades des de la nostra aplicació i, d'aquesta manera, emmagatzemar informació sobre les compres realitzades pels usuaris. Posteriorment, recompensar aquells que realitzin múltiples compres, com podrien ser descomptes.

- Jocs nocturns:
Incorporació d'una nova secció de jocs nocturns com ara simples jocs de trivia, preguntes interactives amb reptes, o altres per promoure l'ús de l'aplicació.

- Filtratge de ressenyes:
Ja sigui per categories com 'Ambient', 'Experiència General' o 'Música', realitzar la cerca de les ressenyes dels usuaris sobre les diferents discoteques per destacar els aspectes més rellevants.

- Comentaris a les ressenyes:
Afegir una nova secció associada a les ressenyes per permetre que els usuaris compartissin les seves opinions i comentaris sobre elles, similar a com estan estructurats els inTimes.

- Fòrums per a cada discoteca:
Establir fòrums per a cada discoteca, funcionant de manera similar a subreddits (veure Reddit), on els usuaris puguin crear comunitats per compartir notícies, events creats per la comunitat, esdeveniments especials i altres informacions rellevants, així com expressar opinions i fer peticions per a millores al local.




    


  

