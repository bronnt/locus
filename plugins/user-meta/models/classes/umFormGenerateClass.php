<?php

if ( ! class_exists( 'umFormGenerate' ) ) :
class umFormGenerate extends umFormBuilder {
    
    protected $formFields;
    
    protected $isAdmin;
    
    protected $actionType;
    
    protected $userID;
    
    function __construct( $formName, $actionType = '', $userID = 0 ) {
        global $userMeta;
        
        parent::__construct( 'form_generate', $formName );
        
        $this->formFields = isset( $this->data['fields'] ) && is_array( $this->data['fields'] ) ? $this->data['fields'] : array();
        
        $this->isAdmin = $userMeta->isAdmin() ? true : false;
        
        $this->actionType = $actionType;
        
        $this->userID = $userID;
        
        $this->_sanitizeForm();
        
        $this->_populate();
    }
    
    function getForm() {
        $this->data['fields'] = $this->formFields;
        return $this->data;
    }
    
    function getField( $id ) {
        return ! empty( $this->formFields[ $id ] ) ? $this->formFields[ $id ] : array();
    }
    
    private function _sanitizeForm() {
        global $userMeta;
        
        $fieldsTypes = $userMeta->umFields();
        
        $this->data['page_count'] = 0;
        
        foreach ( $this->formFields as $id => $field ) {

            if( $field['field_type'] == 'page_heading' )
                $this->data['page_count']++;

            $typeData = $fieldsTypes[ $field['field_type'] ];
            $field['field_group'] = $typeData['field_group'];

            /**
             * Determine Field Name
             */
            $fieldName = null;
            if ( $field['field_group'] == 'wp_default' ) {
                $fieldName = $field['field_type'];
            } else {
                if ( ! empty( $field['meta_key'] ) )
                    $fieldName = $field['meta_key'];
            }  
            
            $field['field_name']  = $fieldName;
            
            // Set readonly incase of read_only_non_admin
            if ( empty( $field['read_only'] ) && ! empty( $field['read_only_non_admin'] ) && ! $this->isAdmin )
                $field['read_only'] = true;

            $this->formFields[ $id ] = $field;
        }
    }
    
    
    private function _populate() {
        global $userMeta;
        
        $user = new WP_User( $this->userID );
        $savedValues = in_array( $this->actionType, array( 'profile', 'public' ) ) ? $user : null;
        
        foreach ( $this->formFields as $id => $field ) {

            /**
             * Determine Field Value
             */
            $fieldValue = null;
            if ( isset( $field['default_value'] ) ) {
                $fieldValue = $userMeta->convertUserContent( $user, $field['default_value'] );
            }       

            $fieldName = $field['field_name'];
            
            if ( isset( $savedValues->$fieldName ) )
                $fieldValue = $savedValues->$fieldName;

            if ( empty( $userMeta->showDataFromDB ) ) {
                if ( isset( $_POST[ $fieldName ] ) )  
                    $fieldValue = $_POST[ $fieldName ];                    
            }

            $field['field_value'] = $fieldValue;

            $this->formFields[ $id ] = $field;
        }
            
        $this->_addConditionalResult();
    }
    
    
    private function _addConditionalResult() {

        foreach ( $this->formFields as $id => $field ) {
            if ( empty( $field['condition']['rules'] ) ) continue;
            if ( ! is_array( $field['condition']['rules'] ) ) continue;
            
            $evals   = array();
            foreach ( $field['condition']['rules'] as $rule ) {
                $this->formFields[ $rule['field_id'] ]['is_parent'] = true;
                $target = $this->formFields[ $rule['field_id'] ]['field_value'];
                switch ( $rule['condition'] ) {
                    case 'is' :
                        $evals[] = $target == $rule['value'] ? true : false;
                    break;

                    case 'is_not' :
                        $evals[] = $target != $rule['value'] ? true : false;
                    break;
                }
            }

            $result = reset( $evals );

            $count = count( $evals );
            if ( $count > 1 ) {
                for ( $i = 1; $i < $count; $i++ ) {
                    if ( 'and' == $field['condition']['relation'] )
                        $result = $result && $evals[ $i ];
                    else
                        $result = $result || $evals[ $i ];
                }
            }

            $visibility = $field['condition']['visibility'];

            if ( ( ( 'show' == $visibility ) && ! $result ) || ( ( 'hide' == $visibility ) && $result ) ) {
                $this->formFields[ $id ]['is_hide'] = true;
            }
            
        }
    }
    
    function validInputFields() {
        $validFields = array();
        
        foreach ( $this->formFields as $field ) {
            if ( empty( $field['field_name'] ) ) continue;
            if ( ! empty( $field['read_only'] ) ) continue;
            if ( ! empty( $field['is_hide'] ) ) continue;
            
            if ( isset( $field['condition'] ) )
                unset( $field['condition'] );
            
            $validFields[ $field['field_name'] ] = $field;
        }
        
        return $validFields;
    }
    
    
}
endif;
