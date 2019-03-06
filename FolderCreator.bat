IF EXIST publicFiles (
	cd publicFiles
	IF NOT EXIST foto (
		mkdir foto
	)
) ELSE (
	mkdir publicFiles
	cd publicFiles
	IF NOT EXIST foto (
		mkdir foto
	)
)

cd..

cd..

IF EXIST uploads (
	cd uploads
	IF EXIST files (
		cd files
		IF NOT EXIST bachiller (
			mkdir bachiller
		)
		IF NOT EXIST cvs (
			mkdir cvs
		)
		IF NOT EXIST djs (
			mkdir djs
		)
		IF NOT EXIST dni (
			mkdir dni
		)
		IF NOT EXIST doctorado (
			mkdir doctorado
		)
		IF NOT EXIST foto (
			mkdir foto
		)
		IF NOT EXIST hojadatos (
			mkdir hojadatos
		)
		IF NOT EXIST maestria (
			mkdir maestria
		)
		IF NOT EXIST sInscripcion (
			mkdir sInscripcion
		)
		IF NOT EXIST sol-ad (
			mkdir sol-ad
		)
	) ELSE (
		mkdir files
		cd files
		IF NOT EXIST bachiller (
			mkdir bachiller
		)
		IF NOT EXIST cvs (
			mkdir cvs
		)
		IF NOT EXIST djs (
			mkdir djs
		)
		IF NOT EXIST dni (
			mkdir dni
		)
		IF NOT EXIST doctorado (
			mkdir doctorado
		)
		IF NOT EXIST foto (
			mkdir foto
		)
		IF NOT EXIST hojadatos (
			mkdir hojadatos
		)
		IF NOT EXIST maestria (
			mkdir maestria
		)
		IF NOT EXIST sInscripcion (
			mkdir sInscripcion
		)
		IF NOT EXIST sol-ad (
			mkdir sol-ad
		)
	)
) ELSE (
	mkdir uploads
	cd uploads
	IF EXIST files (
		cd files
		IF NOT EXIST bachiller (
			mkdir bachiller
		)
		IF NOT EXIST cvs (
			mkdir cvs
		)
		IF NOT EXIST djs (
			mkdir djs
		)
		IF NOT EXIST dni (
			mkdir dni
		)
		IF NOT EXIST doctorado (
			mkdir doctorado
		)
		IF NOT EXIST foto (
			mkdir foto
		)
		IF NOT EXIST hojadatos (
			mkdir hojadatos
		)
		IF NOT EXIST maestria (
			mkdir maestria
		)
		IF NOT EXIST sInscripcion (
			mkdir sInscripcion
		)
		IF NOT EXIST sol-ad (
			mkdir sol-ad
		)
	) ELSE (
		mkdir files
		cd files
		IF NOT EXIST bachiller (
			mkdir bachiller
		)
		IF NOT EXIST cvs (
			mkdir cvs
		)
		IF NOT EXIST djs (
			mkdir djs
		)
		IF NOT EXIST dni (
			mkdir dni
		)
		IF NOT EXIST doctorado (
			mkdir doctorado
		)
		IF NOT EXIST foto (
			mkdir foto
		)
		IF NOT EXIST hojadatos (
			mkdir hojadatos
		)
		IF NOT EXIST maestria (
			mkdir maestria
		)
		IF NOT EXIST sInscripcion (
			mkdir sInscripcion
		)
		IF NOT EXIST sol-ad (
			mkdir sol-ad
		)
	)
)

cd..
cd..
mkdir .\uploads\trash
pause