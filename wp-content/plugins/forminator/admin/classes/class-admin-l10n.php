<?php
if (!defined('ABSPATH')) {
	die();
}

/**
 * Class Forminator_Admin_L10n
 *
 * @since 1.0
 */
class Forminator_Admin_L10n
{

	public $forminator = null;

	public function __construct()
	{
	}

	public function get_l10n_strings()
	{
		$l10n = $this->admin_l10n();

		$admin_locale = require_once forminator_plugin_dir() . 'admin/locale.php';

		$locale = array(
			'' => array(
				'localeSlug' => 'default',
			),
		);

		$l10n['locale'] = array_merge($locale, (array) $admin_locale);

		return apply_filters('forminator_l10n', $l10n);
	}

	/**
	 * Default Admin properties
	 *
	 * @return array
	 */
	public function admin_l10n()
	{
		$properties = array(
			'popup'         => array(
				'form_name_label'              => __('Nombra tu formulario', 'forminator'),
				'form_name_placeholder'        => __('Por ejemplo, formulario de contacto', 'forminator'),
				'name'                         => __('Nombre', 'forminator'),
				'fields'                       => __('Campos', 'forminator'),
				'date'                         => __('Fecha', 'forminator'),
				'clear_all'                    => __('Limpiar todo', 'forminator'),
				'your_exports'                 => __('Tus exportaciones', 'forminator'),
				'edit_login_form'              => __('Editar formulario de inicio de sesión o registro', 'forminator'),
				'edit_scheduled_export'        => __('Editar exportación programada', 'forminator'),
				'frequency'                    => __('Frecuencia', 'forminator'),
				'daily'                        => __('A diario', 'forminator'),
				'weekly'                       => __('Semanalmente', 'forminator'),
				'monthly'                      => __('Mensual', 'forminator'),
				'week_day'                     => __('Día de la semana', 'forminator'),
				'month_day'                    => __('Día del mes', 'forminator'),
				'month_year'                   => __('Mes del año', 'forminator'),
				'monday'                       => __('Lunes', 'forminator'),
				'tuesday'                      => __('Martes', 'forminator'),
				'wednesday'                    => __('Miércoles', 'forminator'),
				'thursday'                     => __('Jueves', 'forminator'),
				'friday'                       => __('Viernes', 'forminator'),
				'saturday'                     => __('Sábado', 'forminator'),
				'sunday'                       => __('Domingo', 'forminator'),
				'day_time'                     => __('Hora del día', 'forminator'),
				'email_to'                     => __('Enviar datos de exportación por correo electrónico a', 'forminator'),
				'email_placeholder'            => __('Por ejemplo, john@doe.com', 'forminator'),
				'schedule_help'                => __("Deje en blanco si no desea recibir exportaciones por correo electrónico.", 'forminator'),
				'congratulations'              => __('¡Felicidades!', 'forminator'),
				'is_ready'                     => __('¡está listo!', 'forminator'),
				'new_form_desc'                => __('Agréguelo a cualquier publicación / página haciendo clic en el botón Forminator, o configúrelo como un widget.', 'forminator'),
				'paypal_settings'              => __('Editar credenciales de PayPal', 'forminator'),
				'preview_cforms'               => __('Vista previa del formulario personalizado', 'forminator'),
				'preview_polls'                => __('Vista previa de la encuesta', 'forminator'),
				'preview_quizzes'              => __('Cuestionario de vista previa', 'forminator'),
				'captcha_settings'             => __('Editar credenciales reCAPTCHA', 'forminator'),
				'currency_settings'            => __('Editar moneda predeterminada', 'forminator'),
				'pagination_entries'           => __('Presentaciones | Configuración de paginación', 'forminator'),
				'pagination_listings'          => __('Listados | Configuración de paginación', 'forminator'),
				'email_settings'               => __('Ajustes del correo electrónico', 'forminator'),
				'uninstall_settings'           => __('Configuración de desinstalación', 'forminator'),
				'privacy_settings'             => __('La configuración de privacidad', 'forminator'),
				'validate_form_name'           => __('¡El nombre del formulario no puede estar vacío! Elija un nombre para su formulario.', 'forminator'),
				'close'                        => __('Cerca', 'forminator'),
				'close_label'                  => __('Cerrar esta ventana de diálogo', 'forminator'),
				'go_back'                      => __('Regresa', 'forminator'),
				'records'                      => __('Registros', 'forminator'),
				'delete'                       => __('Borrar', 'forminator'),
				'confirm'                      => __('Confirmar', 'forminator'),
				'are_you_sure'                 => __('¿Está seguro?', 'forminator'),
				'cannot_be_reverted'           => __('Tenga en cuenta que esta acción no se puede revertir.', 'forminator'),
				'are_you_sure_form'            => __('¿Está seguro de que desea eliminar permanentemente este formulario?', 'forminator'),
				'are_you_sure_poll'            => __('¿Está seguro de que desea eliminar esta encuesta de forma permanente?', 'forminator'),
				'are_you_sure_quiz'            => __('¿Está seguro de que desea eliminar permanentemente este cuestionario?', 'forminator'),
				'delete_form'                  => __('Eliminar formulario', 'forminator'),
				'delete_poll'                  => __('Eliminar encuesta', 'forminator'),
				'delete_quiz'                  => __('Eliminar cuestionario', 'forminator'),
				'confirm_action'               => __('Por favor, confirme que desea realizar esta acción.', 'forminator'),
				'confirm_title'                => __('Confirmar acción', 'forminator'),
				'confirm_field_delete'         => __('Por favor, confirme que desea eliminar este campo', 'forminator'),
				'cancel'                       => __('Cancelar', 'forminator'),
				'save_alert'                   => __('Los cambios que realizó pueden perderse si navega fuera de esta página.', 'forminator'),
				'save_changes'                 => __('Guardar cambios', 'forminator'),
				'save'                         => __('Ahorrar', 'forminator'),
				'export_form'                  => __('Formulario de exportación', 'forminator'),
				'export_poll'                  => __('Exportar encuesta', 'forminator'),
				'export_quiz'                  => __('Exportar prueba', 'forminator'),
				'import_form'                  => __('Formulario de importación', 'forminator'),
				'import_form_cf7'              => __('Importar', 'forminator'),
				'import_form_ninja'            => __('Importar formularios ninja', 'forminator'),
				'import_form_gravity'          => __('Importar formularios de gravedad', 'forminator'),
				'import_poll'                  => __('Importar encuesta', 'forminator'),
				'import_quiz'                  => __('Importar prueba', 'forminator'),
				'enable_scheduled_export'      => __('Habilitar exportaciones programadas', 'forminator'),
				'scheduled_export_if_new'      => __('Enviar correo electrónico solo si hay nuevos envíos', 'forminator'),
				'download_csv'                 => __('Descargar CSV', 'forminator'),
				'scheduled_exports'            => __('Exportaciones programadas', 'forminator'),
				'manual_exports'               => __('Exportaciones manuales', 'forminator'),
				'manual_description'           => __('Descargue la lista de envíos en formato .csv.', 'forminator'),
				'scheduled_description'        => __('Habilite las exportaciones programadas para obtener la lista de envíos en su correo electrónico.', 'forminator'),
				'disable'                      => __('Desactivar', 'forminator'),
				'enable'                       => __('Permitir', 'forminator'),
				'enter_name'                   => __('Ingresa un nombre', 'forminator'),
				'new_form_desc2'               => __('Asigne un nombre a su nuevo formulario, luego ¡comencemos a construir!', 'forminator'),
				'new_poll_desc2'               => __('Asigne un nombre a su nueva encuesta, luego ¡comencemos a construir!', 'forminator'),
				#¡VALOR!
				'learn_more'                   => __('Aprende más', 'forminator'),
				'input_label'                  => __('Etiqueta de entrada', 'forminator'),
				'form_name_validation'         => __('El nombre del formulario no puede estar vacío.', 'forminator'),
				'poll_name_validation'         => __('El nombre de la encuesta no puede estar vacío.', 'forminator'),
				'quiz_name_validation'         => __('El nombre de la prueba no puede estar vacío.', 'forminator'),
				'new_form_placeholder'         => __('Por ejemplo, formulario en blanco', 'forminator'),
				'new_poll_placeholder'         => __('Por ejemplo, encuesta en blanco', 'forminator'),
				'new_quiz_placeholder'         => __('Por ejemplo, mi prueba impresionante', 'forminator'),
				'create'                       => __('Crear', 'forminator'),
				'reset'                        => __('REINICIAR', 'forminator'),
				'disconnect'                   => __('Desconectar', 'forminator'),
				'apply_submission_filter'      => __('Aplicar filtros de envío', 'forminator'),
				'registration_notice'          => __("Esta plantilla le permite crear su propio formulario de registro e insertarlo en una página personalizada. Esto no modifica el formulario de registro predeterminado.", 'forminator'),
				'login_notice'                 => __("Esta plantilla le permite crear su propio formulario de inicio de sesión e insertarlo en una página personalizada. Esto no modifica el formulario de inicio de sesión predeterminado.", 'forminator'),
				'approve_user'                 => __('Aprobar', 'forminator'),
				'registration_name'            => __('registro de usuario', 'forminator'),
				'login_name'                   => __('Inicio de sesión de usuario', 'forminator'),
				'deactivate'                   => __('Desactivar', 'forminator'),
				'deactivateContent'            => __('¿Está seguro de que desea desactivar este complemento?', 'forminator'),
				'deactivateAnyway'             => __('Desactivar de todos modos', 'forminator'),
				'forms'                        => __('Formularios', 'forminator'),
				'quizzes'                      => __('Cuestionarios', 'forminator'),
				'polls'                        => __('Centro', 'forminator'),
				'back'                         => __('Atrás', 'forminator'),
				'settings_label'               => __('Ajustes', 'forminator'),
				'settings_description'         => __('Configura y personaliza el contenido de tu informe.', 'forminator'),
				'label_description'            => __('La etiqueta es para ayudarlo a identificar esta notificación de informe.', 'forminator'),
				'module_description'           => __('Elija un módulo para este informe.', 'forminator'),
				'select_forms'                 => __('Seleccionar formularios', 'forminator'),
				'select_forms_description'     => __('Elija los formularios que desea incluir en este informe.', 'forminator'),
				'all_forms'                    => __('Todas las formas', 'forminator'),
				'selected_forms'               => __('Formularios seleccionados', 'forminator'),
				'selected_forms_description'   => __('Seleccione uno o más formularios para incluir en este informe.', 'forminator'),
				'all_quizzes'                  => __('Todos los cuestionarios', 'forminator'),
				'select_quizzes'               => __('Seleccionar cuestionarios', 'forminator'),
				'selected_quizzes'             => __('Cuestionarios seleccionados', 'forminator'),
				'select_quizzes_description'   => __('Elija las pruebas que desea incluir en este informe.', 'forminator'),
				'selected_quizzes_description' => __('Seleccione uno o más cuestionarios para incluir en este informe.', 'forminator'),
				'all_polls'                    => __('Todas las encuestas', 'forminator'),
				'select_polls'                 => __('Seleccionar encuestas', 'forminator'),
				'selected_polls'               => __('Encuestas seleccionadas', 'forminator'),
				'select_polls_description'     => __('Elija las encuestas que desea incluir en este informe.', 'forminator'),
				'selected_polls_description'   => __('Seleccione una o más encuestas para incluir en este informe.', 'forminator'),
				'report_stats'                 => __('Reportar estadísticas', 'forminator'),
				'all_stats'                    => __('Todas las estadísticas', 'forminator'),
				'stats'                        => __('Estadísticas', 'forminator'),
				'stats_description'            => __('Seleccione los datos de estadísticas para mostrar en estos informes.', 'forminator'),
				'views'                        => __('Puntos de vista', 'forminator'),
				'bounce_rates'                 => __('Tasas de rebote', 'forminator'),
				'submissions'                  => __('Presentaciones', 'forminator'),
				'conversion_rates'             => __('Medidas de conversión', 'forminator'),
				'payments'                     => __('Pagos', 'forminator'),
				'leads'                        => __('Dirige', 'forminator'),
				'schedule_label'               => __('Cronograma', 'forminator'),
				'schedule_description'         => __('Elija la frecuencia con la que desea recibir este correo electrónico de informe.', 'forminator'),
				'frequency_description'        => __('Elija la frecuencia de recepción del correo electrónico del informe.', 'forminator'),

				'frequency_time'               => self::get_timezone_string(),
				'recipients_label'             => __('Destinatarios', 'forminator'),
				'recipients_description'       => __('Agregue los destinatarios de correo electrónico del informe a continuación.', 'forminator'),
				'add_users'                    => __('Agregar usuarios', 'forminator'),
				'add_by_email'                 => __('Añadir por correo electrónico', 'forminator'),
				'search_user'                  => __('Buscar usuarios', 'forminator'),
				'users'                        => __('Usuarios', 'forminator'),
				'search_placeholder'           => __('Escriba nombre de usuario', 'forminator'),
				'no_recipients'                => __("No ha agregado los usuarios. Para activar la notificación, primero debe agregar usuarios.", 'forminator'),
				'no_recipient_disable'         => __("Ha eliminado todos los destinatarios.", 'forminator'),
				'recipient_exists'             => __('El destinatario ya existe.', 'forminator'),
				'add_user'                     => __('Agregar usuario', 'forminator'),
				'added_users'                  => __('Usuarios agregados', 'forminator'),
				'remove_user'                  => __('Quitar usuario', 'forminator'),
				'resend_invite'                => __('Reenviar correo electrónico de invitación', 'forminator'),
				'awaiting_confirmation'        => __('Pendiente de confirmación', 'forminator'),
				'invite_description'           => __('Agregar detalles del destinatario.', 'forminator'),
				'first_name'                   => __('Nombre de pila', 'forminator'),
				'email_address'                => __('Dirección de correo electrónico', 'forminator'),
				'add_recipient'                => __('Agregar destinatario', 'forminator'),
				'adding_recipient'             => __('Agregar destinatario', 'forminator'),
				'name_placeholder'             => __('Por ejemplo, Juan', 'forminator'),
				'invite_no_recipient'          => __('No se agregaron destinatarios. Agregue uno o más destinatarios arriba para terminar de programar el informe.', 'forminator'),
				'status_label'                 => __('Activar informe', 'forminator'),
				'configure'                    => __('Configurar', 'forminator'),
				'deactivate_report'            => __('Desactivar informe', 'forminator'),
				'activate_report'              => __('Activar informe', 'forminator'),
				'time_interval'                => self::get_times(),
				'week_days'                    => forminator_week_days(),
				'month_days'                   => self::get_months(),
				'fetch_nonce'                  => wp_create_nonce('forminator-fetch'),
				'save_nonce'                   => wp_create_nonce('forminator-save'),
			),
			'quiz'          => array(
				'choose_quiz_title'       => __('Crear cuestionario', 'forminator'),
				'choose_quiz_description' => __("Comencemos dándole un nombre a su cuestionario y eligiendo el tipo de cuestionario apropiado según su objetivo.", 'forminator'),
				'quiz_name'               => __('Nombre del cuestionario', 'forminator'),
				'quiz_type'               => __('Tipo de prueba', 'forminator'),
				'collect_leads'           => __('Recoger clientes potenciales', 'forminator'),
				'no_pagination'           => __('sin paginación', 'forminator'),
				'paginate_quiz'           => __('Cuestionario paginado', 'forminator'),
				'presentation'            => __('Presentación', 'forminator'),
				'quiz_pagination'         => __('Presentación del cuestionario', 'forminator'),
				'quiz_pagination_descr'   => __('¿Cómo desea que se presenten las preguntas del cuestionario a sus usuarios? Puede dividir las preguntas de su prueba en páginas y mostrar varias preguntas a la vez o mostrar todas las preguntas a la vez.', 'forminator'),
				'quiz_pagination_descr2'  => __('Puede ajustar esta configuración en cualquier momento en la configuración de Comportamiento de su cuestionario.', 'forminator'),
				'knowledge_label'         => __('Cuestionario de conocimiento', 'forminator'),
				'knowledge_description'   => __('Pruebe el conocimiento de sus visitantes sobre un tema y la puntuación final se calcula en función del número de respuestas correctas. Por ejemplo, Pon a prueba tus conocimientos musicales.', 'forminator'),
				'nowrong_label'           => __('Prueba de personalidad', 'forminator'),
				'nowrong_description'     => __("Muestra diferentes resultados dependiendo de las respuestas del visitante. No hay respuestas equivocadas. Por ejemplo, ¿Qué superhéroe eres?", 'forminator'),
				'continue_button'         => __('Continuar', 'forminator'),
				'quiz_leads_toggle'       => __('Recopile clientes potenciales en su cuestionario', 'forminator'),
				'create_quiz'             => __('Crear cuestionario', 'forminator'),				
				'quiz_leads_desc'         => __('Crearemos automáticamente un formulario de generación de prospectos predeterminado para usted. El formulario de generación de prospectos usa el módulo Formularios, y algunas de las configuraciones se comparten entre este cuestionario y el formulario de prospectos.'),
			),
			'form'          => array(
				'form_template_title'       => __('Elige una plantilla', 'forminator'),
				'form_template_description' => __('Personalice una de nuestras plantillas de formulario prefabricadas o comience desde cero.'),
				'continue_button'           => __('Continuar', 'forminator'),
				'result'                    => __('Resultado', 'forminator'),
				'results'                   => __('Resultados', 'forminator'),
			),
			'sidebar'       => array(
				'label'         => __('Etiqueta', 'forminator'),
				'value'         => __('Valor', 'forminator'),
				'add_option'    => __('Añadir opción', 'forminator'),
				'delete'        => __('Borrar', 'forminator'),
				'pick_field'    => __('Elige un campo', 'forminator'),
				'field_will_be' => __('Este campo será', 'forminator'),
				'if'            => __('Si', 'forminator'),
				'shown'         => __('Mostrado', 'forminator'),
				'hidden'        => __('Oculto', 'forminator'),
				
			),
			'colors'        => array(
				'poll_shadow'       => __('Sombra de encuesta', 'forminator'),
				'title'             => __('Texto del título', 'forminator'),
				'question'          => __('Texto de la pregunta', 'forminator'),
				'answer'            => __('Texto de respuesta', 'forminator'),
				'input_background'  => __('Campo de entrada bg', 'forminator'),
				'input_border'      => __('Borde del campo de entrada', 'forminator'),
				'input_placeholder' => __('Marcador de posición del campo de entrada', 'forminator'),
				'input_text'        => __('Texto del campo de entrada', 'forminator'),
				'btn_background'    => __('Fondo del botón', 'forminator'),
				'btn_text'          => __('Botón de texto', 'forminator'),
				'link_res'          => __('Enlace de resultados', 'forminator'),				
			),
			'options'       => array(
				'browse'                => __('Navegar', 'forminator'),
				'clear'                 => __('Claro', 'forminator'),
				'no_results'            => __("Aún no tienes ningún resultado.", 'forminator'),
				'select_result'         => __('Seleccionar resultado', 'forminator'),
				'no_answers'            => __("Aún no tienes ninguna respuesta.", 'forminator'),
				'placeholder_image'     => __('Haga clic en examinar para agregar una imagen...', 'forminator'),
				'placeholder_image_alt' => __('Haga clic en navegar para agregar una imagen', 'forminator'),
				'placeholder_answer'    => __('Añade una respuesta aquí', 'forminator'),
				'multiqs_empty'         => __("Aún no tienes ninguna pregunta.", 'forminator'),
				'add_question'          => __('Agregar pregunta', 'forminator'),
				'add_new_question'      => __('Agregar nueva pregunta', 'forminator'),
				'question_title'        => __('Título de la pregunta', 'forminator'),
				'question_title_error'  => __('¡El título de la pregunta no puede estar vacío! Por favor, agregue algo de contenido a su pregunta.', 'forminator'),
				'answers'               => __('Respuestas', 'forminator'),
				'add_answer'            => __('Agregar respuesta', 'forminator'),
				'add_new_answer'        => __('Agregar nueva respuesta', 'forminator'),
				'add_result'            => __('Añadir resultado', 'forminator'),
				'delete_result'         => __('Eliminar resultado', 'forminator'),
				'title'                 => __('Título', 'forminator'),
				'image'                 => __('Imagen (opcional)', 'forminator'),
				'description'           => __('Descripción', 'forminator'),
				'trash_answer'          => __('Eliminar esta respuesta', 'forminator'),
				'correct'               => __('Respuesta correcta', 'forminator'),
				'no_options'            => __("Aún no tienes ninguna opción.", 'forminator'),
				'delete'                => __('Borrar', 'forminator'),
				'restricted_dates'      => __('Fechas restringidas:', 'forminator'),
				'add'                   => __('Agregar', 'forminator'),
				'custom_date'           => __('Elija fechas personalizadas para restringir:', 'forminator'),
				'form_data'             => __('Datos del formulario', 'forminator'),
				'required_form_fields'  => __('Campos requeridos', 'forminator'),
				'optional_form_fields'  => __('Campos opcionales', 'forminator'),
				'all_fields'            => __('Todos los campos enviados', 'forminator'),
				'form_name'             => __('Nombre del formulario', 'forminator'),
				'misc_data'             => __('Datos misceláneos', 'forminator'),
				'form_based_data'       => __('Añadir datos de formulario', 'forminator'),
				'been_saved'            => __('Ha sido salvado.', 'forminator'),
				'been_published'        => __('Ha sido publicado.', 'forminator'),				
				'error_saving'          => __('¡Error! El formulario no se puede guardar.'),
				'default_value'         => __('Valor por defecto', 'forminator'),
				'admin_email'           => get_option('admin_email'),
				'delete_question'       => __('Eliminar esta pregunta', 'forminator'),
				'remove_image'          => __('Quita la imagen', 'forminator'),
				'answer_settings'       => __('Mostrar configuraciones adicionales', 'forminator'),
				'add_new_result'        => __('Agregar nuevo resultado', 'forminator'),
				'multiorder_validation' => __('Debe agregar al menos un resultado para este cuestionario para que pueda reordenar la prioridad de los resultados.', 'forminator'),
				'user_ip_address'       => __('Dirección IP del usuario', 'forminator'),
				'date'                  => __('Fecha', 'forminator'),
				'embed_id'              => __('Incrustar ID de publicación/página', 'forminator'),
				'embed_title'           => __('Incrustar título de publicación/página', 'forminator'),
				'embed_url'             => __('Insertar URL', 'forminator'),
				'user_agent'            => __('Agente de usuario HTTP', 'forminator'),
				'refer_url'             => __('URL de referencia HTTP', 'forminator'),
				'display_name'          => __('Nombre para mostrar del usuario', 'forminator'),
				'user_email'            => __('Correo electrónico del usuario', 'forminator'),
				'user_login'            => __('Inicio de sesión de usuario', 'forminator'),
				'shortcode_copied'      => __('El código abreviado se ha copiado correctamente.', 'forminator'),
				'uri_copied'            => __('El URI se ha copiado correctamente.', 'forminator'),
				
			),
			'commons'       => array(
				'color'                          => __('Color', 'forminator'),
				'colors'                         => __('Colores', 'forminator'),
				'border_color'                   => __('Color del borde', 'forminator'),
				'border_color_hover'             => __('Color del borde (pasar el cursor)', 'forminator'),
				'border_color_active'            => __('Color del borde (activo)', 'forminator'),
				'border_color_correct'           => __('Color del borde (correcto)', 'forminator'),
				'border_color_incorrect'         => __('Color del borde (incorrecto)', 'forminator'),
				'border_width'                   => __('Ancho del borde', 'forminator'),
				'border_style'                   => __('Estilo de borde', 'forminator'),
				'background'                     => __('Fondo', 'forminator'),
				'background_hover'               => __('Fondo (pasar el cursor)', 'forminator'),
				'background_active'              => __('Fondo (activo)', 'forminator'),
				'background_correct'             => __('Fondo (correcto)', 'forminator'),
				'background_incorrect'           => __('Fondo (incorrecto)', 'forminator'),
				'font_color'                     => __('Color de fuente', 'forminator'),
				'font_color_hover'               => __('Color de fuente (pasar el cursor)', 'forminator'),
				'font_color_active'              => __('Color de fuente (activo)', 'forminator'),
				'font_color_correct'             => __('Color de fuente (correcto)', 'forminator'),
				'font_color_incorrect'           => __('Color de fuente (incorrecto)', 'forminator'),
				'font_background'                => __('Fondo de fuente', 'forminator'),
				'font_background'                => __('Fondo de fuente (hover)', 'forminator'),
				'font_background_active'         => __('Fondo de fuente (activo)', 'forminator'),
				'font_family'                    => __('Familia tipográfica', 'forminator'),
				'font_family_custom'             => __('Familia de fuentes personalizada', 'forminator'),
				'font_family_placeholder'        => __("P.ej., 'Arial', sans-serif", 'forminator'),
				'font_family_custom_description' => __('Aquí puede escribir la familia de fuentes que desea usar, como lo haría en CSS.', 'forminator'),
				'icon_size'                      => __('Tamaño de ícono', 'forminator'),
				'enable'                         => __('Permitir', 'forminator'),
				'dropdown'                       => __('Desplegable', 'forminator'),
				'appearance'                     => __('Apariencia', 'forminator'),
				'expand'                         => __('Expandir', 'forminator'),
				'placeholder'                    => __('Marcador de posición', 'forminator'),
				'preview'                        => __('Avance', 'forminator'),
				'icon_color'                     => __('Color del icono', 'forminator'),
				'icon_color_hover'               => __('Color del icono (pasar el cursor)', 'forminator'),
				'icon_color_active'              => __('Color del icono (activo)', 'forminator'),
				'icon_color_correct'             => __('Color del icono (correcto)', 'forminator'),
				'icon_color_incorrect'           => __('Color del icono (incorrecto)', 'forminator'),
				'box_shadow'                     => __('Sombra de la caja', 'forminator'),
				'enable_settings'                => __('Habilitar configuración', 'forminator'),
				'font_size'                      => __('Tamaño de fuente', 'forminator'),
				'font_weight'                    => __('Peso de la fuente', 'forminator'),
				'text_align'                     => __('Texto alineado', 'forminator'),
				'regular'                        => __('Regular', 'forminator'),
				'medium'                         => __('Medio', 'forminator'),
				'large'                          => __('Grande', 'forminator'),
				'light'                          => __('Luz', 'forminator'),
				'normal'                         => __('Normal', 'forminator'),
				'bold'                           => __('Atrevido', 'forminator'),
				'typography'                     => __('Tipografía', 'forminator'),
				'padding_top'                    => __('Acolchado superior', 'forminator'),
				'padding_right'                  => __('Acolchado derecho', 'forminator'),
				'padding_bottom'                 => __('Acolchado inferior', 'forminator'),
				'padding_left'                   => __('Relleno izquierdo', 'forminator'),
				'border_radius'                  => __('Radio del borde', 'forminator'),
				'date_placeholder'               => __('20 de abril de 2018', 'forminator'),
				'left'                           => __('Izquierda', 'forminator'),
				'center'                         => __('Centro', 'forminator'),
				'right'                          => __('Bien', 'forminator'),
				'none'                           => __('Ninguno', 'forminator'),
				'solid'                          => __('Sólido', 'forminator'),
				'dashed'                         => __('Punteado', 'forminator'),
				'dotted'                         => __('Punteado', 'forminator'),
				'delete_option'                  => __('Eliminar opción', 'forminator'),
				'label'                          => __('Etiqueta', 'forminator'),
				'value'                          => __('Valor', 'forminator'),
				'reorder_option'                 => __('Reordenar esta opción', 'forminator'),
				'forminator_ui'                  => __('Interfaz de usuario del formador', 'forminator'),
				'forminator_bold'                => __('Formador negrita', 'forminator'),
				'forminator_flat'                => __('Formador plano', 'forminator'),
				'material_design'                => __('Diseño de materiales', 'forminator'),
				'no_file_chosen'                 => __('Ningún archivo elegido', 'forminator'),
				'update_successfully'            => __('Guardado con exito!', 'forminator'),
				'update_unsuccessfull'           => __('¡Error! No se guardaron los ajustes.', 'forminator'),
				'approve_user_successfull'       => __('Usuario aprobado con éxito.', 'forminator'),
				'error_message'                  => __('¡Algo salió mal!', 'forminator'),
				'approve_user_unsuccessfull'     => __('¡Error! El usuario no fue aprobado.', 'forminator'),				
			),
			'social'        => array(
				'facebook'    => __('Facebook', 'forminator'),
				'twitter'     => __('Twitter', 'forminator'),
				'google_plus' => __('Google+', 'forminator'),
				'linkedin'    => __('LinkedIn', 'forminator'),
			),
			'calendar'      => array(
				'day_names_min' => array(
					esc_html__('Domingo', 'forminator'),
					esc_html__('Lunes', 'forminator'),
					esc_html__('Martes', 'forminator'),
					esc_html__('Miércoles', 'forminator'),
					esc_html__('Jueves', 'forminator'),
					esc_html__('Viernes', 'forminator'),
					esc_html__('Sábado', 'forminator'),
				),
				'month_names'   => array(
					esc_html__('Enero', 'forminator'),
					esc_html__('Febrero', 'forminator'),
					esc_html__('Marzo', 'forminator'),
					esc_html__('Abril', 'forminator'),
					esc_html__('Mayo', 'forminator'),
					esc_html__('Junio', 'forminator'),
					esc_html__('Julio', 'forminator'),
					esc_html__('Agosto', 'forminator'),
					esc_html__('Septiembre', 'forminator'),
					esc_html__('Octubre', 'forminator'),
					esc_html__('Noviembre', 'forminator'),
					esc_html__('Deciembre', 'forminator'),
				),
				'day_names_min' => self::get_short_days_names(),
				'month_names'   => self::get_months_names(),
			),
			'exporter'      => array(
				'export_nonce' => wp_create_nonce('forminator_export'),
				'form_id'      => forminator_get_form_id_helper(),
				'form_type'    => forminator_get_form_type_helper(),
				'enabled'      => filter_var(forminator_get_exporter_info('enabled', forminator_get_form_id_helper() . forminator_get_form_type_helper()), FILTER_VALIDATE_BOOLEAN),
				'interval'     => forminator_get_exporter_info('interval', forminator_get_form_id_helper() . forminator_get_form_type_helper()),
				'month_day'    => forminator_get_exporter_info('month_day', forminator_get_form_id_helper() . forminator_get_form_type_helper()),
				'day'          => forminator_get_exporter_info('day', forminator_get_form_id_helper() . forminator_get_form_type_helper()),
				'hour'         => forminator_get_exporter_info('hour', forminator_get_form_id_helper() . forminator_get_form_type_helper()),
				'email'        => forminator_get_exporter_info('email', forminator_get_form_id_helper() . forminator_get_form_type_helper()),
				'if_new'       => forminator_get_exporter_info('if_new', forminator_get_form_id_helper() . forminator_get_form_type_helper()),
				'noResults'    => esc_html__('No se ha encontrado ningún resultado', 'forminator'),
				'searching'    => esc_html__('Buscar en', 'forminator'),
			),
			'exporter_logs' => forminator_get_export_logs(forminator_get_form_id_helper()),
		);

		$properties = self::add_notice($properties);

		return $properties;
	}

	/**
	 * Maybe add notices to properties
	 *
	 * @param array $properties Properties.
	 *
	 * @return array
	 */
	private static function add_notice($properties)
	{
		$key = filter_input(INPUT_GET, 'forminator_notice');
		if ($key) {
			$notices = self::get_notices_list();
			if (!empty($notices[$key])) {
				$properties['notices'][] = $notices[$key];
			}
		}

		$text_notice = filter_input(INPUT_GET, 'forminator_text_notice');
		if ($text_notice) {
			$properties['notices']['custom_notice'] = $text_notice;
		}

		return $properties;
	}

	/**
	 * All possible notices that can be shown after refreshing page
	 *
	 * @return array
	 */
	private static function get_notices_list()
	{
		$list = array(
			'form_deleted'    => __('Formulario eliminado con éxito.', 'forminator'),
			'poll_deleted'    => __('Encuesta eliminada con éxito.', 'forminator'),
			'quiz_deleted'    => __('Cuestionario eliminado con éxito.', 'forminator'),
			'form_duplicated' => __('Formulario duplicado con éxito.', 'forminator'),
			'poll_duplicated' => __('Encuesta duplicada con éxito.', 'forminator'),
			'quiz_duplicated' => __('Cuestionario duplicado con éxito.', 'forminator'),
			'form_reset'      => __('Los datos de seguimiento del formulario se restablecieron correctamente.', 'forminator'),
			'poll_reset'      => __('Los datos de seguimiento de la encuesta se restablecieron correctamente.', 'forminator'),
			'quiz_reset'      => __('Los datos de seguimiento del cuestionario se restablecieron correctamente.', 'forminator'),
			'preset_deleted'  => __('El preajuste seleccionado se ha eliminado correctamente.', 'forminator'),			
		);

		return $list;
	}

	/**
	 * Get short days names html escaped and translated
	 *
	 * @return array
	 * @since 1.5.4
	 */
	public static function get_short_days_names()
	{
		return array(
			esc_html__('Domingo', 'forminator'),
			esc_html__('Lunes', 'forminator'),
			esc_html__('Martes', 'forminator'),
			esc_html__('Miércoles', 'forminator'),
			esc_html__('Jueves', 'forminator'),
			esc_html__('Viernes', 'forminator'),
			esc_html__('Sábado', 'forminator'),
		);
	}

	/**
	 * Get months names html escaped and translated
	 *
	 * @return array
	 * @since 1.5.4
	 */
	public static function get_months_names()
	{
		return array(
			esc_html__('Enero', 'forminator'),
			esc_html__('Febrero', 'forminator'),
			esc_html__('Marzo', 'forminator'),
			esc_html__('Abril', 'forminator'),
			esc_html__('Mayo', 'forminator'),
			esc_html__('Junio', 'forminator'),
			esc_html__('Julio', 'forminator'),
			esc_html__('Agosto', 'forminator'),
			esc_html__('Septiembre', 'forminator'),
			esc_html__('Octubre', 'forminator'),
			esc_html__('Noviembre', 'forminator'),
			esc_html__('Deciembre', 'forminator'),
		);
	}

	/**
	 * Return times frame for select box
	 *
	 * @return mixed
	 * @since 1.20.0
	 *
	 */
	private static function get_times()
	{
		$data = array();
		for ($i = 0; $i < 24; $i++) {
			foreach (apply_filters('forminator_get_times_interval', array('00')) as $min) {
				$time_key   = $i . ':' . $min;
				$time_value = date_format(date_create($time_key), 'h:i A');
				$data[]     = apply_filters('forminator_get_times_hour_min', $time_value);
			}
		}

		return apply_filters('forminator_get_times', $data);
	}

	/**
	 * Return time zone string.
	 *
	 * @return string
	 * @since 3.1.1
	 *
	 */
	private static function get_timezone_string()
	{
		$current_offset = get_option('gmt_offset');
		$tzstring       = get_option('timezone_string');

		if (empty($tzstring)) { // Create a UTC+- zone if no timezone string exists.
			if (0 === $current_offset) {
				$tzstring = 'UTC+0';
			} elseif ($current_offset < 0) {
				$tzstring = 'UTC' . $current_offset;
			} else {
				$tzstring = 'UTC+' . $current_offset;
			}
		}

		$timezone_string = sprintf(
			/* translators: %1$s - time zone, %2$s - current time */
			esc_html__('Your site\'s current time is %1$s %2$s based on your %3$sWordPress Settings%4$s', 'forminator'),
			'<strong>' . esc_html(date_i18n('h:i a')) . '</strong>',
			'<strong>' . esc_html($tzstring) . '</strong>',
			'<a href="' . esc_url(network_admin_url('options-general.php')) . '" target="_blank">',
			'</a>'
		);

		return $timezone_string;
	}

	/**
	 * Return months frame for select box
	 *
	 * @return mixed
	 * @since 1.20.0
	 *
	 */
	private static function get_months()
	{
		$days_data = array();
		$days      = range(1, 28);
		foreach ($days as $day) {
			$days_data[] = $day;
		}

		return apply_filters('forminator_get_months', $days_data);
	}
}
