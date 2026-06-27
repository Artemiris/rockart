<?php


namespace common\utility;


use common\models\Petroglyph;
use Yii;

class PetroglyphPdfUtil
{
    static function GetPetroglyphPdfObject($petroglyph):array
    {
        $petroglyph_image_objects = [];
        if(!empty($petroglyph->image)){
            $petroglyph_image_objects[] = [
                'name' => Yii::t('model', 'Image'),
                'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImage,
                'author' => $petroglyph->img_author,
                'copyright' => $petroglyph->img_copyright,
                'source' => $petroglyph->img_source
            ];
        }
        if(!empty($petroglyph->im_dstretch)){
            $petroglyph_image_objects[] = [
                'name' => Yii::t('model', 'Image DStretch'),
                'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDstretch,
                'author' => $petroglyph->ds_img_author,
                'copyright' => $petroglyph->ds_img_copyright,
                'source' => $petroglyph->ds_img_source
            ];
        }
        if(!empty($petroglyph->im_drawing)){
            $petroglyph_image_objects[] = [
                'name' => Yii::t('model', 'Drawing image'),
                'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDrawing,
                'author' => $petroglyph->dr_img_author,
                'copyright' => $petroglyph->dr_img_copyright,
                'source' => $petroglyph->dr_img_source
            ];
        }
        if(!empty($petroglyph->im_overlay)){
            $petroglyph_image_objects[] = [
                'name' => Yii::t('model', 'Image overlay'),
                'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImOverlay,
                'author' => $petroglyph->ov_img_author,
                'copyright' => $petroglyph->ov_img_copyright,
                'source' => $petroglyph->ov_img_source
            ];
        }
        if(!empty($petroglyph->im_reconstruction)){
            $petroglyph_image_objects[] = [
                'name' => Yii::t('model', 'Reconstruction image'),
                'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImReconstr,
                'author' => $petroglyph->re_img_author,
                'copyright' => $petroglyph->re_img_copyright,
                'source' => $petroglyph->re_img_source
            ];
        }

        $petroglyph_attrib_objects = [];
        if(!empty($petroglyph->cultures)){
            $petroglyph_attrib_objects[] = [
                'name' => Yii::t('app', 'Culture'),
                'data' => implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->cultures))
            ];
        }
        if(!empty($petroglyph->epochs)){
            $petroglyph_attrib_objects[] = [
                'name' => Yii::t('app', 'Epoch'),
                'data' => implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->epochs))
            ];
        }
        if(!empty($petroglyph->styles)){
            $petroglyph_attrib_objects[] = [
                'name' => Yii::t('app', 'Style'),
                'data' => implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->styles))
            ];
        }
        if(!empty($petroglyph->methods)){
            $petroglyph_attrib_objects[] = [
                'name' => Yii::t('app', 'Method'),
                'data' => implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->methods))
            ];
        }

        return [
            'petroglyph' => $petroglyph,
            'petroglyph_image_objects' => $petroglyph_image_objects,
            'petroglyph_attribute_objects' => $petroglyph_attrib_objects
        ];
    }
}