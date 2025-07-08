<?php

namespace App\Actions\v1\Helpers\Order;

use App\DTOs\v1\Helpers\Order\UpdateContentOrderDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;

class UpdateElementOrderAction
{
    protected $element;
    protected $element_parent;
    protected $foreign_key_name;

    public function __construct($element, $element_parent = null, $foreign_key_name = null)
    {
        $this->element = $element;
        $this->element_parent = $element_parent;
        $this->foreign_key_name = $foreign_key_name;
    }

    public function execute(UpdateContentOrderDto $elementDto)
    {
        return $this
            ->createElement($elementDto)
            ->buildResponse($elementDto);
    }

    protected function createElement(UpdateContentOrderDto $elementDto): self
    {
        for ($i = 0; $i < count($elementDto->items); $i++) {
            $element = $this->element::where("id", $elementDto->items[$i]["id"]);
            if ($this->element_parent) {
                $element =  $element->where($this->foreign_key_name, $this->element_parent->id);
            }
            $element =  $element->update(["index" => $i + 1]);
        }

        return $this;
    }

    protected function buildResponse($elementDto)
    {
        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.update.success', ['name' => trans('custom.attribute.element-order')]))
            ->build();
    }
}
