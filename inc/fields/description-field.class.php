<?php
require_once(realpath(dirname(__FILE__ ) . '/../../../../inc/includes.php'));
require_once('field.interface.php');

class descriptionField implements Field
{
   public static function show($field, $datas)
   {
      $hide = ($field['show_type'] == 'hide') ? ' style="display: none"' : '';
      echo '<div class="description_field form-group" id="form-group-field' . $field['id'] . '"' . $hide . '>';
      echo html_entity_decode($field['description']);

      switch ($field['show_condition']) {
         case 'notequal':
            $condition = '!=';
            break;
         case 'lower':
            $condition = '<';
            break;
         case 'greater':
            $condition = '>';
            break;

         default:
            $condition = '==';
            break;
      }

      if ($field['show_type'] == 'hide') {
         $conditionnalField = new PluginFormcreatorQuestion();
         $conditionnalField->getFromDB($field['show_field']);

         switch ($conditionnalField->fields['fieldtype']) {
            case 'checkboxes' :
               echo '<script type="text/javascript">
                  var inputElements = document.getElementsByName("formcreator_field_' . $field['show_field'] . '[]");

                  for(var i=0; inputElements[i]; ++i) {
                     if (inputElements[i].addEventListener) {
                        inputElements[i].addEventListener("change", function(){showFormGroup' . $field['id'] . '()});
                     } else {
                        inputElements[i].attachEvent("onchange", function(){showFormGroup' . $field['id'] . '()});
                     }
                  }

                  function showFormGroup' . $field['id'] . '() {
                     var checkedValue = false;

                     for(var i=0; inputElements[i]; ++i) {
                        if (inputElements[i].value ' . $condition . ' "' . $field['show_value'] . '" && inputElements[i].checked) {
                           checkedValue = true;
                        }
                     }

                     if(checkedValue) {
                        document.getElementById("form-group-field' . $field['id'] . '").style.display = "block";
                     } else {
                        document.getElementById("form-group-field' . $field['id'] . '").style.display = "none";
                     }
                  }
                  showFormGroup' . $field['id'] . '();
               </script>';
               break;
            case 'multiselect' :
               echo '<script type="text/javascript">
                  var inputElements = document.getElementsByName("formcreator_field_' . $field['show_field'] . '[]")[1];
                     if (inputElements.addEventListener) {
                        inputElements.addEventListener("change", function(){showFormGroup' . $field['id'] . '()});
                     } else {
                        inputElements.attachEvent("onchange", function(){showFormGroup' . $field['id'] . '()});
                     }

                  function showFormGroup' . $field['id'] . '() {
                     var checkedValue = false;

                     for(var i=0; inputElements[i]; ++i) {
                        if (inputElements[i].value ' . $condition . ' "' . $field['show_value'] . '" && inputElements[i].selected) {
                           checkedValue = true;
                        }
                     }

                     if(checkedValue) {
                        document.getElementById("form-group-field' . $field['id'] . '").style.display = "block";
                     } else {
                        document.getElementById("form-group-field' . $field['id'] . '").style.display = "none";
                     }
                  }
                  showFormGroup' . $field['id'] . '();
               </script>';
               break;
            case 'radios' :
               echo '<script type="text/javascript">
                  var inputElements = document.getElementsByName("formcreator_field_' . $field['show_field'] . '");

                  for(var i=0; inputElements[i]; ++i) {
                     if (inputElements[i].addEventListener) {
                        inputElements[i].addEventListener("change", function(){showFormGroup' . $field['id'] . '()});
                     } else {
                        inputElements[i].attachEvent("onchange", function(){showFormGroup' . $field['id'] . '()});
                     }
                  }

                  function showFormGroup' . $field['id'] . '() {
                     var checkedValue = false;

                     for(var i=0; inputElements[i]; ++i) {
                        if (inputElements[i].value ' . $condition . ' "' . $field['show_value'] . '" && inputElements[i].checked) {
                           checkedValue = true;
                        }
                     }

                     if(checkedValue) {
                        document.getElementById("form-group-field' . $field['id'] . '").style.display = "block";
                     } else {
                        document.getElementById("form-group-field' . $field['id'] . '").style.display = "none";
                     }
                  }
                  showFormGroup' . $field['id'] . '();
               </script>';
               break;
            default :
               echo '<script type="text/javascript">
                  var element = document.getElementsByName("formcreator_field_' . $field['show_field'] . '")[0];
                  if (element.addEventListener) {
                     element.addEventListener("change", function(){showFormGroup' . $field['id'] . '()});
                  } else {
                     element.attachEvent("onchange", function(){showFormGroup' . $field['id'] . '()});
                  }
                  function showFormGroup' . $field['id'] . '() {
                     var field_value = document.getElementsByName("formcreator_field_' . $field['show_field'] . '")[0].value;
                     if(field_value ' . $condition . ' "' . $field['show_value'] . '") {
                        document.getElementById("form-group-field' . $field['id'] . '").style.display = "block";
                     } else {
                        document.getElementById("form-group-field' . $field['id'] . '").style.display = "none";
                     }
                  }
                  showFormGroup' . $field['id'] . '();
               </script>';
         }
      }

      echo '</div>' . PHP_EOL;
   }

   public static function displayValue($value, $values)
   {
      return '';
   }

   public static function isValid($field, $value, $datas)
   {
      return true;
   }

   public static function getName()
   {
      return __('Description');
   }

   public static function getPrefs()
   {
      return array(
         'required'       => 0,
         'default_values' => 0,
         'values'         => 0,
         'range'          => 0,
         'show_empty'     => 0,
         'regex'          => 0,
         'show_type'      => 1,
         'dropdown_value' => 0,
         'glpi_objects'   => 0,
         'ldap_values'    => 0,
      );
   }

   public static function getJSFields()
   {
      $prefs = self::getPrefs();
      return "tab_fields_fields['description'] = 'showFields(" . implode(', ', $prefs) . ");';";
   }
}
