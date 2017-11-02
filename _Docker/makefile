default:
	@echo "Creando contenedor traducciones server server"
	docker stop traducciones_server || echo "No existe"
	docker rm traducciones_server || echo "No se puede eliminar"
	docker build --tag traducciones_server .
	docker run --name traducciones_server -v ~/proyectos/traducciones/Server/university_translations_server:/var/www/university_translations_server -P -d -p 8020:80 traducciones_server  
	@echo "Escuchando por el 8020"

