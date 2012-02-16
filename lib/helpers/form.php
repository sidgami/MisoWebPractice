<?php
class Form {
	static function build($params) {
		if (empty($params['action'])) $params['action'] = $_SERVER['REQUEST_URI'];
		if (empty($params['fields'])) $params['fields'] = array();
		if (empty($params['method'])) $params['method'] = 'post';

		$form_body = '';

		foreach ($params['fields'] as $key => $field_params) {
			if (!is_array($field_params)) {
				$form_body .= $field_params;
				continue;
			}

			if (is_int($key) && isset($field_params['type']) && !is_array($field_params['type']) && $field_params['type'] != 'fieldset') {
				$form_body .= Form::item($field_params);
				continue;
			}

			$fieldsets = !empty($field_params['fieldsets']) ? $field_params['fieldsets'] : array($key => $field_params);

			foreach ($fieldsets as $key => $fieldset_params) {
				if (!isset($fieldset_params['fields'])) {
					$fieldset_params = array(
						'fields' => $fieldset_params,
						'legend' => $key,
					);
				} else {
					if (!isset($fieldset_params['legend'])) $fieldset_params['legend'] = $key;
				}

				$form_body .= Form::build_fieldset($fieldset_params);
			}
		}

		if (strpos($form_body, 'type="file"') && empty($params['enctype'])) {
			$params['enctype'] = 'multipart/form-data';
		}

		$form = '<form';
		$form .= ' action="' . $params['action'] . '"';
		if (!empty($params['class'])) $form .= ' class="' . $params['class'] . '"';
		if (!empty($params['enctype'])) $form .= ' enctype="' . $params['enctype'] . '"';
		if (!empty($params['id'])) $form .= ' id="' . $params['id'] . '"';
		$form .= ' method="' . $params['method'] . '"';
		if (!empty($parmas['name'])) $form .= ' name="' . $params['name'] . '"';
		$form .= '>';
		$form .= $form_body;
		$form .= '</form>';
		return $form;
	}

	static function build_fieldset($params) {
		$fieldset = '';

		$fieldset .= '<fieldset';
		if (!empty($params['class'])) $fieldset .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $fieldset .= ' id="' . $params['id'] . '"';
		$fieldset .= '>';

		if (!empty($params['legend'])) $fieldset .= '<legend>' . $params['legend'] . '</legend>';
		$fieldset .= Form::item_list($params['fields']);

		$fieldset .= '</fieldset>';
		return $fieldset;
	}

	static function checkbox($params) {
		if (!isset($params['value'])) $params['value'] = 1;

		$checkbox = '<input type="checkbox"';
		if (!empty($params['checked'])) $checkbox .= ' checked="checked"';
		if (!empty($params['class'])) $checkbox .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $checkbox .= ' id="' . $params['id'] . '"';
		if (!empty($params['name'])) $checkbox .= ' name="' . $params['name'] . '"';
		if (!empty($params['title'])) $checkbox .= ' title="' . $params['title'] . '"';
		$checkbox .= ' value="' . htmlspecialchars($params['value']) . '"';
		$checkbox .= ' />';
		if (isset($params['text'])) $checkbox .= ' <label class="inline" for="' . (!empty($params['id']) ? $params['id'] : '') . '">' . $params['text'] . '</label>';
		return $checkbox;
	}

	static function dropdown($params) {
		if (!isset($params['values'])) $params['values'] = array();

		$dropdown = '<select';
		if (!empty($params['class'])) $dropdown .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $dropdown .= ' id="' . $params['id'] . '"';
		if (!empty($params['size'])) $dropdown .= ' size="' . $params['size'] . '"';
		if (!empty($params['name'])) $dropdown .= ' name="' . $params['name'] . '"';
		if (!empty($params['title'])) $dropdown .= ' title="' . $params['title'] . '"';
		$dropdown .= '>';

		foreach ($params['values'] as $value => $label) {
			$dropdown .= '<option';
			$dropdown .= ' value="' . htmlspecialchars($value) . '"';

			if (
				isset($params['value'])
				&& (
					(strlen($params['value']) > 0 && $value == $params['value'])
					|| (strlen($params['value']) == 0 && strlen($value) == 0)
				)
			) {
				$dropdown .= ' selected="selected"';
			}

			$dropdown .= '>' . $label . '</option>';
		}

		$dropdown .= '</select>';
		return $dropdown;
	}

	static function errors_to_labels($errors) {
		if (empty($errors) or !is_array($errors)) {
			return array();
		}

		$return_errors = array();

		foreach ($errors as $field => $error) {
			$section = (is_array($error) && strlen($field) > 3) ? $field : null;
			$these_errors = is_array($error) ? $error : array($error);

			foreach ($these_errors as $key =>  $error) {
				$key = !empty($section) ? $section . '-' . $key : $key;
				$return_error = '<label class="error">';
				if (!empty($section)) $return_error .= $section . ': ';
				$return_error .= $error . '</label>';
				$return_errors[] = $return_error;
			}
		}

		return $return_errors;
	}

    static function errors_to_labels_string($errors) {
        $errors = implode('', Form::errors_to_labels($errors));
        if (!empty($errors)) $errors = '<p>' . $errors . '</p>';
        return $errors;
    }

	static function file($params) {
		$file = '<input type="file"';
		if (!empty($params['class'])) $file .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $file .= ' id="' . $params['id'] . '"';
		if (!empty($params['name'])) $file .= ' name="' . $params['name'] . '"';
		if (!empty($params['title'])) $file .= ' title="' . $params['title'] . '"';
		$file .= ' />';
		return $file;
	}

	static function hidden($params) {
		$hidden = '<input type="hidden"';
		$params['class'] = !empty($params['class']) ? 'hidden ' . $params['class'] : 'hidden';
		$hidden .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $hidden .= ' id="' . $params['id'] . '"';
		if (!empty($params['name'])) $hidden .= ' name="' . $params['name'] . '"';
		if (!empty($params['title'])) $hidden .= ' title="' . $params['title'] . '"';
		if (!empty($params['value'])) $hidden .= ' value="' . htmlspecialchars($params['value']) . '"';
		$hidden .= ' />';
		return $hidden;
	}

	static function image($params) {
		$image = '<input type="image"';
		if (!empty($params['class'])) $image .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $image .= ' id="' . $params['id'] . '"';
		if (!empty($params['name'])) $image .= ' name="' . $params['name'] . '"';
		$image .= ' src="' . $params['src'] . '"';
		if (!empty($params['title'])) $image .= ' title="' . $params['title'] . '"';
		if (!empty($params['value'])) $image .= ' value="' . htmlspecialchars($params['value']) . '"';
		$image .= ' />';
		return $image;
	}

	static function input($params) {
		$input = '<input type="text"';
		$params['class'] = !empty($params['class']) ? 'input ' . $params['class'] : 'input';
		$input .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $input .= ' id="' . $params['id'] . '"';
		if (!empty($params['name'])) $input .= ' name="' . $params['name'] . '"';
		if (!empty($params['size'])) $input .= ' size="' . $params['size'] . '"';
		if (!empty($params['title'])) $input .= ' title="' . $params['title'] . '"';
		if (!empty($params['value'])) $input .= ' value="' . htmlspecialchars($params['value']) . '"';
		$input .= ' />';
		return $input;
	}

	static function item($params) {
		if (!isset($params['id'])) $params['id'] = '';

		if ($params['type'] == 'submit' || $params['type'] == 'hidden') {
			$params['label'] = false;
		}

		if ($params['type'] != 'submit' && (!array_key_exists('label', $params)) || $params['label'] !== false) {
			$label_params = $params;
			$label_params['for'] = $params['id'];

			if (empty($params['label']) && !empty($params['name'])) {
				$params['label'] = ucwords(str_replace(array('-', '_'), ' ', $params['name']));
			}

			$label_params['name'] = $params['label'];
			$label = Form::label($label_params);
		} else {
			$label = '';
		}

		if (!empty($params['value']) && !empty($params['date'])) {
			$params['value'] = date('m/d/Y', strtotime($params['value']));
		} elseif (!empty($params['value']) && !empty($params['datetime'])) {
			$params['value'] = date('m/d/Y H:i:s', strtotime($params['value']));
		} elseif (!empty($params['value']) && !empty($params['timestamp'])) {
			$params['value'] = date('m/d/Y H:i:s', $params['value']);
		}

		if ($params['type'] == 'checkbox') {
			$field = Form::checkbox($params);
		} elseif ($params['type'] == 'dropdown') {
			$field = Form::dropdown($params);
		} elseif ($params['type'] == 'file') {
			$field = Form::file($params);
		} elseif ($params['type'] == 'hidden') {
			$label = null;
			$params['list_item'] = false;
			$field = Form::hidden($params);
		} elseif ($params['type'] == 'html') {
			$field = $params['value'];
		} elseif ($params['type'] == 'input') {
			$field = Form::input($params);
		} elseif ($params['type'] == 'multiselect') {
			$field = Form::multiselect($params);
		} elseif ($params['type'] == 'password') {
			$field = Form::password($params);
		} elseif ($params['type'] == 'radio') {
			$field = Form::radio($params);
		} elseif ($params['type'] == 'reset') {
			$field = Form::reset($params);
		} elseif ($params['type'] == 'submit') {
			$field = Form::submit($params);
		} elseif ($params['type'] == 'text') {
			$field = Form::text($params);
		} elseif ($params['type'] == 'textarea') {
			$field = Form::textarea($params);
		} else {
			return '';
		}

		if (empty($params['label_after'])) {
			$item = $label . $field;
		} else {
			$item = $field . $label;
		}

		if (!empty($params['list_item'])) $item = '<li>' . $item . '</li>';
		return $item;
	}

	static function item_list($fields) {
		$hidden_fields = array();
		$list = '<ol>';

		foreach ($fields as $name => $params) {
			if (!is_array($params)) {
				$list .= $params;
				continue;
			}

			$var = !empty($params['field']) ? $params['field'] : $name;
			if (!isset($params['id'])) $params['id'] = $var;
			if (!isset($params['name'])) $params['name'] = $var;
			if (!isset($params['type'])) $params['type'] = 'input';
			$params['list_item'] = true;
			$item = Form::item($params);

			if ($params['type'] == 'hidden') {
				$hidden_fields[] = $item;
			} else {
				$list .= $item;
			}
		}

		$list .= '</ol>';

		foreach ($hidden_fields as $field) {
			$list .= $field;
		}

		return $list;
	}

	static function label($params) {
		if (!isset($params['class'])) $params['class'] = '';
		if (!isset($params['for'])) $params['for'] = '';
		if (!isset($params['name'])) $params['name'] = '';
		if (!empty($params['inline_label'])) $params['class'] .= ' inline';
		$label = '<label';
		if (!empty($params['class'])) $label .= ' class="' . $params['class'] . '"';
		$label .= ' for="' . $params['for'];
		$label .= '">';
		$label .= $params['name'];
		$label .= '</label>';
		return $label;
	}

	static function multiselect($params) {
		if (isset($params['name']) && substr($params['name'], -2) != '[]') $params['name'] .= '[]';
		if (!isset($params['values'])) $params['values'] = array();

		$multiselect = '<select multiple="multiple"';
		if (!empty($params['class'])) $multiselect .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $multiselect .= ' id="' . $params['id'] . '"';
		if (!empty($params['name'])) $multiselect .= ' name="' . $params['name'] . '"';
		if (!empty($params['size'])) $multiselect .= ' size="' . $params['size'] . '"';
		if (!empty($params['title'])) $multiselect .= ' title="' . $params['title'] . '"';
		$multiselect .= '>';

		foreach ($params['values'] as $value => $label) {
			$multiselect .= '<option';
			$multiselect .= ' value="' . htmlspecialchars($value) . '"';
			if (isset($params['value']) && $value == $params['value']) $multiselect .= ' selected="selected"';
			$multiselect .= '>' . $label . '</option>';
		}

		$multiselect .= '</select>';
		return $multiselect;
	}

	static function password($params) {
		$password = '<input type="password"';
		$params['class'] = !empty($params['class']) ? 'password ' . $params['class'] : 'password';
		$password .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $password .= ' id="' . $params['id'] . '"';
		if (!empty($params['name'])) $password .= ' name="' . $params['name'] . '"';
		if (!empty($params['size'])) $password .= ' size="' . $params['size'] . '"';
		if (!empty($params['title'])) $password .= ' title="' . $params['title'] . '"';
		if (!empty($params['value'])) $password .= ' value="' . htmlspecialchars($params['value']) . '"';
		$password .= ' />';
		return $password;
	}

	static function radio($params) {
		if (!isset($params['value'])) $params['value'] = 1;

		$radio = '<input type="radio"';
		if (!empty($params['checked'])) $radio .= ' checked="checked"';
		if (!empty($params['class'])) $radio .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $radio .= ' id="' . $params['id'] . '"';
		if (!empty($params['name'])) $radio .= ' name="' . $params['name'] . '"';
		if (!empty($params['title'])) $radio .= ' title="' . $params['title'] . '"';
		$radio .= ' value="' . htmlspecialchars($params['value']) . '"';
		$radio .= ' />';
		if (isset($params['text'])) $radio .= ' <label class="inline" for="' . (!empty($params['id']) ? $params['id'] : '') . '">' . $params['text'] . '</label>';
		return $radio;
	}

	static function reset($params) {
		if (!isset($params['value'])) $params['value'] = 'Reset';

		$reset = '<input type="reset"';
		if (!empty($params['class'])) $reset .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $reset .= ' id="' . $params['id'] . '"';
		if (!empty($params['title'])) $reset .= ' title="' . $params['title'] . '"';
		$reset .= ' value="' . htmlspecialchars($params['value']) . '"';
		$reset .= ' />';
		return $reset;
	}

	static function submit($params) {
		if (!isset($params['value'])) $params['value'] = 'Submit';

		$submit = '<input type="submit"';
		if (!empty($params['class'])) $submit .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $submit .= ' id="' . $params['id'] . '"';
		if (!empty($params['name'])) $submit .= ' name="' . $params['name'] . '"';
		if (!empty($params['title'])) $submit .= ' title="' . $params['title'] . '"';
		$submit .= ' value="' . htmlspecialchars($params['value']) . '"';
		$submit .= ' />';
		return $submit;
	}

	static function text($params) {
		$text = '<span';
		$text .= ' class="text';
		if (!empty($params['class'])) $text .= ' ' . $params['class'];
		$text .= '"';
		if (!empty($params['title'])) $text .= ' title="' . $params['title'] . '"';
		$text .= '>';
		if (!empty($params['value'])) $text .= htmlspecialchars($params['value']);
		$text .= '</span>';
		return $text;
	}

	static function textarea($params) {
		if (!isset($params['value'])) $params['value'] = '';

		$textarea = '<textarea';
		if (!empty($params['class'])) $textarea .= ' class="' . $params['class'] . '"';
		if (!empty($params['id'])) $textarea .= ' id="' . $params['id'] . '"';
		if (!empty($params['name'])) $textarea .= ' name="' . $params['name'] . '"';
		if (!empty($params['cols'])) $textarea .= ' cols="' . $params['cols'] . '"';
		if (!empty($params['rows'])) $textarea .= ' rows="' . $params['rows'] . '"';
		if (!empty($params['title'])) $textarea .= ' title="' . $params['title'] . '"';
		$textarea .= '>';
		$textarea .= htmlspecialchars($params['value']);
		$textarea .= '</textarea>';
		return $textarea;
	}

	static function update_field_values($fields, $values) {
		foreach ($fields as $key => $value) {
			$type = !empty($value['type']) ? $value['type'] : 'input';

			if ($type == 'checkbox' || $type == 'radio') {
				$fields[$key]['checked'] = !empty($values[$key]);
			} elseif ($type == 'text' || $type == 'html') {
				continue;
			} else {
				$fields[$key]['value'] = $values[$key];
			}
		}

		return $fields;
	}
}