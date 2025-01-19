<?php

namespace App\Nova\Actions\Product;

use App\Models\Product\Product;
use Ayvazyan10\Imagic\Imagic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;

class ProductImageUpload extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Upload Product Images';
    public $onlyOnIndex = true;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        try {
            $images_list = json_decode($fields->images, true);

            foreach ($images_list as $m) {
                $fileName = basename($m);
                $product = Product::where("product_code", pathinfo($fileName, PATHINFO_FILENAME))->first();
                if ($product) {
                    $product->image_url = str_replace('/storage', '', $m);
                    $product->save();
                }
            }
            return Action::message("Product image Upload done!");
        } catch (\Exception $e) {
            return Action::danger($e->getMessage());
        }
        //
    }

    /**
     * Get the fields available on the action.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     * @throws \Exception
     */
    public function fields(NovaRequest $request)
    {
        return [
            Heading::make("
                <div class='text-secondary m-0 font-bold'>
                    <span class='text-red-500 text-sm'>*</span>
                    Select Multiple Image with product code.
                </div>
            ")->asHtml(),
            Imagic::make('Images', "images")
                ->multiple()
//                ->directory("product_image")
                ->help("Use .png, .jpg images only.")
                ->convert(false)
                ->required(),
        ];
    }
}
