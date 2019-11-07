	var opt_1 = new Array("-","VI Doctorado en Desarrollo y Seguridad Estratégica");
		var opt_2 = new Array("-","VII Maestría en Derechos Humanos, Derecho Internacional, Humanitario y Resolución de Conflictos");
		var opt_3 = new Array("-","I Diplomado Especial en Administración y Gestión Pública");
        var opt_4 = new Array("-","I Curso Plan Operativo Institucional (POI)");
		function cambia(){
			var cosa;
			cosa = document.frm1.programa[document.frm1.programa.selectedIndex].value;
			if(cosa!=0){
				mis_opts=eval("opt_"+cosa);
				num_opts=mis_opts.length;
				document.frm1.opt.length = num_opts;
				for(i=0; i<num_opts; i++){
					document.frm1.opt.options[i].value=mis_opts[i];
					document.frm1.opt.options[i].text=mis_opts[i];
				}
				}else{
					document.frm1.opt.length = 1;
					document.frm1.opt.options[0].value ="-"; 
					document.frm1.opt.options[0].text ="-"; 
				}
				document.frm1.opt.options[0].selected= true;
			}