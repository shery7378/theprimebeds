<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $type_required =
            $this->item_type == "digital" || $this->item_type == "license"
                ? ""
                : "required";

        $check_link = "";
        $check_file = "";
        $id = $this->item ? "," . $this->item->id : "";
        $required = $this->item ? "" : "required|";

        return [
            "name" => "required|max:255",
            "slug" => "required",
            "unique:items,slug" . $id,
            'regex:/^[a-zA-Z0-9-]+$/',
            "category_id" => "required",
            "details" => "required",
            "link" => "nullable",
            "file" => "nullable|file|mimes:zip",
            "sort_details" => "required",
            "discount_price" => "required|max:50",
            "previous_price" => "max:50",
            "stock" => "numeric|max:9999999999",
            "photo" => $required,
            "mimes:jpeg,jpg,png,svg",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "name.required" => __("Name field is required."),
            "category_id.required" => __("Category field is required."),
            "brand_id.required" => __("Brand field is required."),
            "slug.required" => __("Slug field is required."),
            "slug.unique" => __("This slug has already been taken."),
            "details.required" => __("Description field is required."),
            "sort_details.required" => __(
                "Sort Description field is required.",
            ),
            "discount_price.required" => __("Current Price field is required."),
            "stock.required" => __("Stock field is required."),
            "photo.required" => __("Image field is required."),
            "photo.mimes" => __("Image type must be jpg,jpeg,png,svg."),
        ];
    }
}
