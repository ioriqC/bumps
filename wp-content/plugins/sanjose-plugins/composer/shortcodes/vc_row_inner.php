<?php
/*
 * VC Сolumn Params
 * Version: 1.0.0
 * Add option for column paddings and margins
 */

$responsive_classes = array(
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Large Desctop margin top', 'js_composer' ),
        'param_name'  => 'large_desctop_mt',
        'value'       => cr_get_row_offset('margin-lg', 't', 200),
        'group'       => 'Responsive Margins'
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Large Desctop margin bottom', 'js_composer' ),
        'param_name'  => 'large_desctop_mb',
        'value'       => cr_get_row_offset('margin-lg', 'b', 200),
        'group'       => 'Responsive Margins',
    ),
	array(
        'type'        => 'dropdown',
        'heading'     => __( 'Desctop margin top', 'js_composer' ),
        'param_name'  => 'desctop_mt',
        'value'       => cr_get_row_offset('margin-md', 't', 200),
        'group'       => 'Responsive Margins'
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Desctop margin bottom', 'js_composer' ),
        'param_name'  => 'desctop_mb',
        'value'       => cr_get_row_offset('margin-md', 'b', 200),
        'group'       => 'Responsive Margins',
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Tablets margin top', 'js_composer' ),
        'param_name'  => 'tablets_mt',
        'value'       => cr_get_row_offset('margin-sm', 't', 200),
        'group'       => 'Responsive Margins'
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Tablets margin bottom', 'js_composer' ),
        'param_name'  => 'tablets_mb',
        'value'       => cr_get_row_offset('margin-sm', 'b', 200),
        'group'       => 'Responsive Margins'
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Mobile margin top', 'js_composer' ),
        'param_name'  => 'mobile_mt',
        'value'       => cr_get_row_offset('margin-xs', 't', 200),
        'group'       => 'Responsive Margins'
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Mobile margin bottom', 'js_composer' ),
        'param_name'  => 'mobile_mb',
        'value'       => cr_get_row_offset('margin-xs', 'b', 200),
        'group'       => 'Responsive Margins'
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Large Desctop padding top', 'js_composer' ),
        'param_name'  => 'large_desctop_pt',
        'value'       => cr_get_row_offset('padding-lg', 't', 200),
        'group'       => 'Responsive Paddings'
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Large Desctop padding bottom', 'js_composer' ),
        'param_name'  => 'large_desctop_pb',
        'value'       => cr_get_row_offset('padding-lg', 'b', 200),
        'group'       => 'Responsive Paddings',
    ),
	array(
        'type'        => 'dropdown',
        'heading'     => __( 'Desctop padding top', 'js_composer' ),
        'param_name'  => 'desctop_pt',
        'value'       => cr_get_row_offset('padding-md', 't', 200),
        'group'       => 'Responsive Paddings'
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Desctop padding bottom', 'js_composer' ),
        'param_name'  => 'desctop_pb',
        'value'       => cr_get_row_offset('padding-md', 'b', 200),
        'group'       => 'Responsive Paddings',
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Tablets padding top', 'js_composer' ),
        'param_name'  => 'tablets_pt',
        'value'       => cr_get_row_offset('padding-sm', 't'),
        'group'       => 'Responsive Paddings'
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Tablets padding bottom', 'js_composer' ),
        'param_name'  => 'tablets_pb',
        'value'       => cr_get_row_offset('padding-sm', 'b', 200),
        'group'       => 'Responsive Paddings'
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Mobile padding top', 'js_composer' ),
        'param_name'  => 'mobile_pt',
        'value'       => cr_get_row_offset('padding-xs', 't', 200),
        'group'       => 'Responsive Paddings'
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Mobile padding bottom', 'js_composer' ),
        'param_name'  => 'mobile_pb',
        'value'       => cr_get_row_offset('padding-xs', 'b', 200),
        'group'       => 'Responsive Paddings'
    ),
);

vc_add_params( 'vc_row_inner', $responsive_classes );
