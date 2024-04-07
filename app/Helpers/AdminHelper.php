<?php
namespace App\Helpers;

use App\Models\Category;
use Intervention\Image\Facades\Image;

class AdminHelper
{
    private $html;
    public function __construct()
    {
        $this->html = '';
    }

    public function dataTree($parentId, $id = 0, $text = '')
    {
        $data = Category::all();
        foreach ($data as $value) {
            if ($value['parent_id'] == $id) {
                if (!empty($parentId) && $parentId == $value['id']) {
                    $this->html .= '<option selected value="' . $value->id . '"> ' . $text . $value['name'] . ' </option>';
                } else {
                    $this->html .= '<option value="' . $value->id . '"> ' . $text . $value['name'] . ' </option>';
                }
                $this->dataTree($parentId, $value['id'], $text . ' - - ');
            }
        }
        return $this->html;
    }

    public function ImageResize($file, $folder, $width = 870, $height = 490)
    {
        if (is_array($file) == 1) {
            $arr = [];
            foreach ($file as $image) {
                $name = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize($width, $height);
                $image_resize->save(public_path('uploads/' . $folder . '/' . $name));
                $arr[] = $name;
            }
            return implode('|', $arr);
        } else {

            $image = $file;
            $name = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize($width, $height);
            $image_resize->limitColors(255, '#ff9900');
            $image_resize->save(public_path('uploads/' . $folder . '/' . $name));

            return $name;
        }
    }

    public function FormatPrice($price)
    {
        return floatval(preg_replace('/[^\d.]/', '', $price));
    }
}
