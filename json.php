<?php 
/*
**
** Atributos permitidos:
** type: text|email|tel|password|select|textarea|checkbox|radio|button
** name: Nombre del campo
** title: titulo o texto a mostrar del campo
** label: titulo o texto del campo dentro de etiqueta label (si existe se omite title)
** value: (opcional) Valor del campo si se requiere, necesario en selects
** placeholder: (opcional) texto dentro del campo placeholder
** size: tamaño del campo
** maxlength: indica el tamaño maximo del campo
** rows: Cantidad de filas para los campos textarea
** cols: cantidad de columnas para los campos textarea
** buttontype: input|button Si el campo es un boton indica el tipo de boton a mostrar, default es button
** buttonmethod: button|submit|reset Metodo de funcion del boton, default es submit
** required: true|false indica si el campo es obligatorio, por default el valor es false
** readonly: true|false indica si el campo es solo de lectura
** disabled: true|false indica si el campo inicia desabilitado o no, por default es false y no se agrega
** class: (opcional) class del campo
** id: (opcional) id del campo
** divprepend: Contenido de div anterior al campo field 
** divprependClass: clase de divprepend
** divappend: Contenido de div posterior al campo field 
** divappendClass: clase de divappend
** classLabel: (opcional) agrega una clase a la etiqueta label
** classField: (opcional) si se especifica se encierra el campo en un div con la clase indicada
** classContainer: (opcional) Agrega una clase al contenedor del label y campo
**
*/

$campo = '{type:"text", label:"Titulo del campo", value:"", placeholder : "placeholder del campo, opcional", required:true, class:"clase css", id:"prueba", classLabel:"control-label", divprepend:"$", divprependClass:"input-group-addon", divappend:".00", divappendClass:"input-group-addon", classField:"col-sm-6", classContainer:"form-group"},
	{type:"password",label:"Password", placeholder:"Password", classContainer:"form-group col-sm-6"},
	{type:"select", title:"Titulo del select", value:"*Valor de entrada, Valor 1|valor_1, Valor 2|valor_2, Valor 3|valor_3", placeholder : "placeholder del campo, opcional", required:true, class:"clase css"},
	{type:"checkbox", label:"Checkbox", name:"check", value:"Si, No", classContainer:"form-group"},
	{type:"radio", label:"Radio", name:"radio", value:"Si, No", classContainer:"form-group"},
	{type:"textarea", label:"Text area", name:"txarea", value:"Valor del textarea",rows:"4",cols:"30" , classContainer:"form-group"},
	{type:"button",value:"Boton button"},
	{type:"button",buttontype:"input",value:"Boton submit"}';

// Optimiza la cadena de texto
$cadena = preg_replace('/(\w+)\s?:/i', '"\1":', !empty($campo)?$campo:"{}");
if(substr_count($cadena, '{') > 1) {$cadena = "[".$cadena."]";}
$campos = (array)json_decode($cadena,true);

// Crea el form
echo "<form>\n";

// Recorre cada campo
foreach ($campos as $campo) {

	// Agrega un div contenedor para el campo, en Bootstrap se usa form-group
	if ( isset($campo{'classContainer'}) && $campo{'classContainer'}!=='' ){
		echo '<div class="'.$campo{'classContainer'}.'">'."\n";
	}

	// Si no existe un label agrega la etiqueta title
	if ( ( isset($campo{'title'}) && $campo{'title'} ) && ( !isset($campo{'label'}) || $campo{'label'} ==='' ) ){
		echo '<span class="title-form">' . $campo{'title'} . '</span>'."\n";
	}

	// Agrega la etiqueta label, permite agregar Class e ID
	if ( isset($campo{'label'}) && $campo{'label'} !=='' ){
		echo '<label';
		if ( isset($campo{'id'}) && $campo{'id'} !=='' ) { echo ' for="'.$campo{'id'}.'"'; }
		if ( isset($campo{'classLabel'}) && $campo{'classLabel'} !=='' ){ echo 'class="' . $campo{'classLabel'}.'" '; }
		echo '>' . $campo{'label'} . '</label>'."\n";
	}

	// Se puede agregar un div contenedor del campo
	if ( isset($campo{'classField'}) && $campo{'classField'} !=='' ){
		echo '<div class="'. $campo{'classField'} .'">'."\n";
	}

	// Se puede agregar un div con contenido antes del campo, se puede agregar una class al div
	if ( isset($campo{'divprepend'}) && $campo{'divprepend'} !=='' ){
		echo '<div class="'. $campo{'divprependClass'} .'">' . $campo{'divprepend'} . '</div>'."\n";
	}

	// Se comprueba si existe definicion del tipo de campo
	if ( isset($campo{'type'}) ):

		// Se guarda el tipo de campo, se convierte a minusculas y se limpian espacios
		$campo_type = strtolower(trim($campo{'type'}));

		// Crea campo para text, email, tel y password
		if ( $campo_type === 'text' || $campo_type === 'email' || $campo_type === 'tel' || $campo_type === 'password' ){

			$campo_text = '';

			$campo_text .= '<input type="' . $campo{'type'} . '" ';

				if ( isset($campo{'name'}) && $campo{'name'} )
					$campo_text .= 'name="' . $campo{'name'} . '" ';

				if ( isset($campo{'value'}) && $campo{'value'} )
					$campo_text .= 'value="' . $campo{'value'} . '" ';

				if ( isset($campo{'placeholder'}) && $campo{'placeholder'} )
					$campo_text .= 'placeholder="' . $campo{'placeholder'} . '" ';

				if ( isset($campo{'class'}) && $campo{'class'} )
					$campo_text .= 'class="' . $campo{'class'} . '" ';

				if ( isset($campo{'id'}) && $campo{'id'} )
					$campo_text .= 'id="' . $campo{'id'} . '" ';

				if ( isset($campo{'size'}) && $campo{'size'} )
					$campo_text .= 'size="' . $campo{'size'} . '" ';

				if ( isset($campo{'maxlength'}) && $campo{'maxlength'} )
					$campo_text .= 'maxlength="' . $campo{'maxlength'} . '" ';

				if ( isset($campo{'required'}) && $campo{'required'} === true )
					$campo_text .= 'required ';

				if ( isset($campo{'readonly'}) && $campo{'readonly'} === true )
					$campo_text .= 'readonly ';

				if ( isset($campo{'disabled'}) && $campo{'disabled'} === true )
					$campo_text .= 'disabled ';

			$campo_text .= '>';

			echo $campo_text."\n";

		}

		// Armado de campos select
		elseif ( $campo_type === 'select' ){

			$campo_select = '';

			$campo_select .= '<select ';

				if ( isset($campo{'name'}) && $campo{'name'} )
					$campo_select .= 'name="' . $campo{'name'} . '" ';

				if ( isset($campo{'class'}) && $campo{'class'} )
					$campo_select .= 'class="' . $campo{'class'} . '" ';

				if ( isset($campo{'id'}) && $campo{'id'} )
					$campo_select .= 'id="' . $campo{'id'} . '" ';

				if ( isset($campo{'required'}) && $campo{'required'} === true )
					$campo_select .= 'required ';

				if ( isset($campo{'readonly'}) && $campo{'readonly'} === true )
					$campo_select .= 'readonly ';

				if ( isset($campo{'disabled'}) && $campo{'disabled'} === true )
					$campo_select .= 'disabled ';

			$campo_select .= '>'."\n";

			$valores = explode(",", trim($campo{'value'}));

			foreach ($valores as $valor) {

				$opcion = explode('|',$valor);
				$sel = strpos($opcion[0], '*');

				$campo_select .= '<option value="';
				if ( isset($opcion[1])) { $campo_select .= $opcion[1]; }
				$campo_select .= '"';
				if ( !$sel === false ) { $campo_select .= ' selected'; }
				$campo_select .= '>' . str_replace('*', '', trim($opcion[0])) . '</option>'."\n";

			}

			$campo_select .= '</select>';

			echo $campo_select."\n";

		}

		// Armado de campos textarea
		elseif ( $campo_type === 'textarea' ){

			$campo_textarea = '';

			$campo_textarea .= '<textarea ';

				if ( isset($campo{'name'}) && $campo{'name'} )
					$campo_textarea .= 'name="' . $campo{'name'} . '" ';

				if ( isset($campo{'rows'}) && $campo{'rows'} )
					$campo_textarea .= 'rows="' . $campo{'rows'} . '" ';

				if ( isset($campo{'cols'}) && $campo{'cols'} )
					$campo_textarea .= 'cols="' . $campo{'cols'} . '" ';

				if ( isset($campo{'placeholder'}) && $campo{'placeholder'} )
					$campo_textarea .= 'placeholder="' . $campo{'placeholder'} . '" ';

				if ( isset($campo{'class'}) && $campo{'class'} )
					$campo_textarea .= 'class="' . $campo{'class'} . '" ';

				if ( isset($campo{'id'}) && $campo{'id'} )
					$campo_textarea .= 'id="' . $campo{'id'} . '" ';

				if ( isset($campo{'required'}) && $campo{'required'} === true )
					$campo_textarea .= 'required ';

				if ( isset($campo{'readonly'}) && $campo{'readonly'} === true )
					$campo_textarea .= 'readonly ';

				if ( isset($campo{'disabled'}) && $campo{'disabled'} === true )
					$campo_textarea .= 'disabled ';

			$campo_textarea .= '>';
			if ( isset($campo{'value'}) && $campo{'value'} !== '' ) { $campo_textarea .= $campo{'value'}; }
			$campo_textarea .= '</textarea>';

			echo $campo_textarea."\n";
			
		}

		// Armado de campos Checkbox & Radio
		elseif ( $campo_type === 'checkbox' || $campo_type === 'radio' ){

			$campo_check = '';

			if ( isset( $campo{'value'} ) && $campo{'value'} !=='' ):

				$valores = explode(",", trim($campo{'value'}));

				foreach ($valores as $valor) {

					$sel = strpos($valor, '*');

					$campo_check .= '<input type="' . $campo{'type'} . '" ';

					if ( isset($campo{'name'}) && $campo{'name'} )
						$campo_check .= 'name="' . $campo{'name'} . '" ';

					if ( isset($campo{'class'}) && $campo{'class'} )
						$campo_check .= 'class="' . $campo{'class'} . '" ';

					if ( isset($campo{'id'}) && $campo{'id'} )
						$campo_check .= 'id="' . $campo{'id'} . '" ';

					if ( !$sel === false ) { $campo_check .= ' checked'; }
					$campo_check .= 'value="' . str_replace('*', '', trim($valor)) . '" ';

					if ( isset($campo{'required'}) && $campo{'required'} === true )
						$campo_check .= 'required ';

					if ( isset($campo{'readonly'}) && $campo{'readonly'} === true )
						$campo_check .= 'readonly ';

					if ( isset($campo{'disabled'}) && $campo{'disabled'} === true )
						$campo_check .= 'disabled ';			

					$campo_check .= '>'."\n";

				}

			endif;

			echo $campo_check."\n";

		}

		// Armado de botones
		elseif ( $campo_type === 'button' ){

			if ( isset($campo{'buttontype'}) && $campo{'buttontype'} !=='' ) { 
				$button_type = $campo{'buttontype'}; 
			}else{
				$button_type = 'button';
			}

			if ( isset($campo{'buttonmethod'}) && $campo{'buttonmethod'} !=='' ) { 
				$button_method = $campo{'buttonmethod'}; 
			}else{
				$button_method = 'submit';
			}

			$boton_attribs = '';
			if ( isset($campo{'name'}) && $campo{'name'} )
				$boton_attribs .= 'name="' . $campo{'name'} . '" ';

			if ( isset($campo{'class'}) && $campo{'class'} )
				$boton_attribs .= 'class="' . $campo{'class'} . '" ';

			if ( isset($campo{'id'}) && $campo{'id'} )
				$boton_attribs .= 'id="' . $campo{'id'} . '" ';


			if ( $button_type == 'button' ){

				$boton  = '<button type="'.$button_method.'" ';
				if ( isset($boton_attribs) && $boton_attribs !=='' ) { $boton .= $boton_attribs; }
				$boton .= '>';

				if ( isset($campo{'value'}) && $campo{'value'} !== '' ) { $boton .= $campo{'value'}; }
				$boton .= '</button>';

			}else{

				$boton = '<input type="'.$button_method.'" ';
				if ( isset($boton_attribs) && $boton_attribs !=='' ) { $boton .= $boton_attribs; }
				if ( isset($campo{'value'}) && $campo{'value'} !== '' ) { $boton .= 'value="' . $campo{'value'} . '" '; }
				$boton .= '>';

			}

			echo $boton."\n";

		}

		// Se puede agregar un div despues del campo
		if ( isset($campo{'divappend'}) && $campo{'divappend'} !=='' ){
			echo '<div class="'. $campo{'divappendClass'} .'">' . $campo{'divappend'} . '</div>'."\n";
		}

		// Si se agrego un div contenedor del campo aqui se cierra
		if ( isset($campo{'classField'}) && $campo{'classField'} !=='' ){
			echo '</div>'."\n";
		}

	endif;

	// Cierra etiquete contenedora de campo
	if ( isset($campo{'classContainer'}) && $campo{'classContainer'}!=='' ){

		echo '</div>'."\n";

	}

}

echo "</form>\n";