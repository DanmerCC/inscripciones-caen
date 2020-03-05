	var opt_1 = new Array("-","VI Doctorado en Desarrollo y Seguridad Estratégica", "III Políticas Públicas y Gestión del Estado");
		var opt_2 = new Array("-","XII Administración y Gestión Pública, V Inteligencia Estratégica, III Gestión del Riesgo de Desastres, Estudios Estratégicos y Seguridad Internacional");
		var opt_3 = new Array("-","I Especial de Administración y Gestión Pública", "III Especial de gestión del Riesgo de Desastres", "III Ciberseguridad y Ciberdefensa", "II Seguridad Ciudadana, I en Gestión de Proyectos e Inversión Pública", "I Inteligencia Competitiva");
        var opt_4 = new Array("-","VIII de Actualización", "II Gestión Efectiva de Conflicto", "XI de Altos Estudios en Política y Estrategia(CAEPE)","V de Seguridad Estrategica y Alta Dirección", "I Semi Presencial en Investigación Cualitativa", "Plan Operativo Insitucional");
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