<?php

if ( ! class_exists( 'umFormBuilder' ) ) :
class umFormBuilder {
    
    protected $name;
    
    protected $data = array();
    
    protected $found;
    
    protected $allFields;
        
    protected $elements;
    
    protected $editor;
    
    protected $nonce;
    
    private $maxID;
    
    public $redirect_to;
    
    function __construct( $editor = null, $formName = null ) {
        global $userMeta;
        
        $this->editor   = $editor;
        $this->name     = $formName;

        $this->_loadAllFields();
        
        if ( ! empty( $this->name ) )
            $this->_initForm();
        
        if ( ! empty( $this->editor ) )
            $this->_init();
    }
    
    private function _init() {
        $this->nonce    = wp_create_nonce( 'pf' . ucwords( $this->editor ) );
        
        switch ( $this->editor ) {
            
            case 'fields_editor' :
            break;
        
            case 'form_editor' :
                $this->elementList();
                $this->_setFormFieldsDropdown(); 
            break;
        }
    }
    
    private function _initForm() {
        global $userMeta;
        
        if ( empty( $this->name ) ) return;
        
        $forms  = $userMeta->getData( 'forms' );
        if ( isset( $forms[ $this->name ] ) ) {
            $this->found    = true;
            $this->data     = $forms[ $this->name ];
        }
     
        $formFields = array();
        if ( ! empty( $this->data['fields'] ) && is_array( $this->data['fields'] ) ) {
            foreach ( $this->data['fields'] as $id => $field ) {
                $id     = is_array( $field ) ? $id : $field;
                $field  = is_array( $field ) ? $field : array();
                if ( ! empty( $this->allFields[ $id ] ) && is_array( $this->allFields[ $id ] ) ) {
                    $field  = array_merge( $this->allFields[ $id ], $field );
                    $field['is_shared'] = true;
                }
                
                $field['id'] = $id;
                
                if ( ! empty( $field['field_type'] ) )
                    $formFields[ $id ] = $field;
            }
        }

        $this->data['fields'] = $formFields;
    }    
    
    private function _loadAllFields() {
        global $userMeta;
        
        $allFields = $userMeta->getData( 'fields' );
        $this->allFields    = is_array( $allFields ) ? $allFields : array();
    }
    
    private function _setFormFieldsDropdown() {
        global $userMeta;
        
        $fieldsType = $userMeta->umFields();
        
        $fieldsList = array();
        if ( ! empty( $this->data['fields'] ) && is_array( $this->data['fields'] ) ) {
            foreach ( $this->data['fields'] as $id => $field ) {
                if ( empty( $field['field_type'] ) ) continue;
                
                if ( ! empty( $fieldsType[ $field['field_type'] ]['field_group'] ) ) {
                    if ( 'formatting' == $fieldsType[ $field['field_type'] ]['field_group'] )
                        continue;
                }             

                $typeTitle = $fieldsType[ $field['field_type'] ]['title'];
                $label = 'ID:' . $id . ' (' . $typeTitle . ') ';
                if ( ! empty( $field['field_title'] ) )
                    $label .= $field['field_title'];
                $fieldsList[ $id ] = $label;
            }
        }
        
        umFieldBuilder::$formFieldsDropdown = $fieldsList;
    }
        
    private function elementList() {
        global $userMeta;
        
        $elements = array(
            'button_title'   => array(
                'label'         => __( 'Submit Button Title',$userMeta->name ),
                'placeholder'   => 'Keep blank for default value',
            ),
            'button_class'   => array(
                'label'         => __( 'Submit Button Class',$userMeta->name ),
                'placeholder'   => 'Assign class to submit button',
            ),
            'form_class'   => array(
                'label'         => __( 'Form Class',$userMeta->name ),
                'placeholder'   => 'Keep blank for default value',
            ),
            'disable_ajax'   => array(
                'type'          => 'checkbox',
                'label'         => __( 'Do not use AJAX submit', $userMeta->name ),
            ),
        );
        
        $this->elements = $elements;
    }
    
    function isFound() {
        return $this->found ? true : false;
    }
    
    function getAllFields() {
        return $this->allFields;
    }
    
    function displaySettings() {
        global $userMeta;
        
        extract( $this->data );

        $html = null;
        foreach( $this->elements as $name => $args ) {
            $args = wp_parse_args( $args, array(
                'type'          => 'text',
                'value'         => isset( $$name ) ? $$name : null, 
                'class'         => 'form-control',
                'label_class'   => 'col-sm-2 control-label',
                'field_enclose' => 'div class="col-sm-6"',
                'enclose'       => 'div class="form-group"',
            ) );
            
            $type = $args['type'];
            unset( $args['type'] );
            
            if ( 'checkbox' == $type ) {
                $args['label_class'] = 'col-sm-offset-2 col-sm-6';
                $args['field_enclose'] = '';
                $args['enclose'] = 'p class="form-group"';
            }
            
            $options = array();
            if ( isset( $args['options'] ) ) {
                $options = $args['options'];
                unset( $args['options'] );
            }
            
            $html .= $userMeta->createInput( $name, $type, $args, $options );
        }
        
        $html = '<div class="form-horizontal" role="form">' . $html . '</div>';
        
        return $html;
    }
    
    function displayFormFields() {
        global $userMeta;
        
        if ( ! empty( $this->data['fields'] ) && is_array( $this->data['fields'] ) ) {
            foreach ( $this->data['fields'] as $field ) {
                $fieldBuilder = new umFieldBuilder( $field );
                $fieldBuilder->setEditor( $this->editor );
                echo $fieldBuilder->buildPanel();
            }
        }
    }
    
    function displayAllFields() {
        global $userMeta;
        
        foreach ( $this->allFields as $id => $field ) {
            $field['id'] = $id;
            $fieldBuilder = new umFieldBuilder( $field );
            $fieldBuilder->setEditor( $this->editor );
            echo $fieldBuilder->buildPanel();
        }
    }
    
    function getMaxFieldID() {
        global $userMeta;
        
        $config = $userMeta->getData( 'config' );
        
        if ( ! empty( $config['max_field_id'] ) )
            return (int) $config['max_field_id'];
        
        if ( ! empty( $this->allFields ) )
            $id = max( array_keys( $this->allFields ) );
        
        return ! empty( $id ) ? $id : 0;
    }
    
    function setMaxFieldID( $id = 0 ) {
        global $userMeta;
        
        if ( empty( $id ) )
            $id = $this->maxID;

        if ( empty( $id ) ) return;

        $config = $userMeta->getData( 'config' );
        $config = is_array( $config ) ? $config : array();
        $config['max_field_id'] = (int) $id;
        $userMeta->updateData( 'config', $config );
    }
    
    function maxFieldInmput() {
        $id = $this->getMaxFieldID();
        return '<input type="hidden" name="init_max_id" id="um_init_max_id" value="'. $id .'"/>'
                . '<input type="hidden" name="max_id" id="um_max_id" value="'. $id .'"/>';
    }
    
    function additional() {
        return '<input type="hidden" id="um_editor" value="'. $this->editor .'"/>'
                . '<input type="hidden" id="um_common_nonce" value="'. $this->nonce .'"/>';
    }
    
    function fieldsSelectorPanels() {
        global $userMeta;
        
        $fieldTypes = $userMeta->umFields();
        
        $nonce = wp_create_nonce( 'pf' . ucwords( 'add_field' ) );
        
        $fieldsGroup = array();
        foreach ( $fieldTypes as $name => $field ) {
            if ( empty( $field ) ) continue;

            $disbled = ! $field['is_free'] && ! $userMeta->isPro() ? true : false;
            $button = $this->_createButton( $name, $field['title'], array(
                'disable'   => $disbled,
                'nonce'     => $nonce
            ) );
            
            if ( isset( $fieldsGroup[ $field['field_group'] ] ) )
                $fieldsGroup[ $field['field_group'] ] .= $button;
            else
                $fieldsGroup[ $field['field_group'] ] = $button;
        }

        $fieldsGroupTitle = array(
            'wp_default'    => 'WordPress Default Fields',
            'standard'      => 'Extra Fields',
            'formatting'    => 'Formatting Fields'
        );
        
        foreach ( $fieldsGroup as $key => $body ) {
            $userMeta->buildPanel( $fieldsGroupTitle[ $key ], $body  );
        }
    }
    
    function sharedFieldsSelectorPanel() {
        global $userMeta;
        $fieldsType = $userMeta->umFields();
        
        $nonce = wp_create_nonce( 'pf' . ucwords( 'add_field' ) );
        
        $buttons = null;
        foreach( $this->allFields as $id => $field ) {
            $typeTitle = $fieldsType[ $field['field_type'] ]['title'];
            $label = 'ID:' . $id . ' (' . $typeTitle . ') ';
            if ( ! empty( $field['field_title'] ) )
                $label .= $field['field_title'];
            
            $hidden = isset( $this->data['fields'][ $id ] ) ? true : false;
            
            $buttons .= $this->_createButton( $field['field_type'], $label, array(
                'id'        => $id,
                'hidden'    => $hidden,
                'nonce'     => $nonce,
                'is_shared' => true
            ) );
        }
        
        $userMeta->buildPanel( 'Shared Fields', $buttons  );
    }
    
    private function _createButton( $type, $label, $args = array() ) {
        $id     = ! empty( $args['id'] ) ? $args['id'] : 0;
        $class  = ! empty( $id ) ? 'col-xs-12' : 'col-xs-5.5';
        $more   = '';
        
        $btnClass = 'btn-default';
        if ( ! empty( $args['is_shared'] ) ) {
            $more .= ' data-is-shared="1"';
            $btnClass = 'btn-info';
        }
            
            
        if ( ! empty( $args['disable'] ) )
            $more .= ' disabled="disabled" onclick="umGetProMessage(this)"';
        
        if ( ! empty( $args['hidden'] ) )
            $more .= ' style="display:none"';
             
        return "<button type=\"button\" data-field-type=\"$type\" data-field-id=\"$id\""
        . "data-nonce=\"{$args['nonce']}\" $more class=\"btn $btnClass um_field_selecor $class\" >$label</button>";
    }
    
    /**
     * Set for $_POST
     */
    function sanitizeFieldsIDs( $fields ) {
        if ( ! is_array( $fields ) ) return array();
        
        /**
         * Changing to array key
         */
        $sanitize = array();
        foreach ( $fields as $field ) {
            if ( empty( $field['id'] ) ) continue;
            
            $id = $field['id'];
            unset( $field['id'] );
            $sanitize[ $id ] = $field;
        }
        $fields = $sanitize;
        
        $sysMaxID   = $this->getMaxFieldID();
        $formInitID = (int) esc_attr( $_POST['init_max_id'] );
        $formMaxID  = (int) esc_attr( $_POST['max_id'] );
        
        if ( ( $sysMaxID > $formInitID ) && ( $formMaxID > $formInitID ) ) {
            $diff = $sysMaxID - $formInitID;
            
            $sanitize = array();
            foreach ( $fields as $id => $field ) {
                if ( $id > $formInitID )
                    $sanitize[ $id + $diff ] = $field;
                else 
                    $sanitize[ $id ] = $field;
            }
            $fields = $sanitize;
            
            $this->maxID = $formMaxID + $diff;
            
            if ( ! empty( $_SERVER['HTTP_REFERER'] ) )
                $this->redirect_to = $_SERVER['HTTP_REFERER'];
        } elseif ( $formMaxID > $formInitID  ) {
            $this->maxID = $formMaxID;
        } else 
            $this->maxID = 0;
            
        
        return $fields;
    }
    
}
endif;
