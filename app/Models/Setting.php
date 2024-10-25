<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * Get all items.
     *
     * @return collect
     */
    public static function getAll()
    {
        $settings = self::select('*')->get();
        $result = self::defaultSettings();

        foreach ($settings as $setting) {
            $result[$setting->name]['value'] = $setting->value;
        }

        return $result;
    }

    /**
     * Get setting.
     *
     * @return object
     */
    public static function get($name, $defaultValue = null)
    {
        $setting = self::where('name', $name)->first();

        if ($setting) {
            return json_decode($setting->value);
        } elseif (isset(self::defaultSettings()[$name])) {
            return self::defaultSettings()[$name]['value'];
        } else {
            // @todo exception case not handled
            return $defaultValue;
        }
    }

    /**
     * Set setting value.
     *
     * @return object
     */
    public static function set($name, $val)
    {
        $option = self::where('name', $name)->first();
        $val = json_encode($val);

        if ($option) {
            $option->value = $val;
        } else {
            $option = new self();
            $option->name = $name;
            $option->value = $val;
        }
        $option->save();

        return $option;
    }

    /**
     * Default setting.
     *
     * @return object
     */
    public static function defaultSettings()
    {
        return [
            'backup.server.times' => [
                'value' => ['6:00', '8:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00'],
            ],
            'backup.cloud.times' => [
                'value' => ['6:00', '12:00', '1:30'],
            ],
            'hubspot.auto_update' => [
                'value' => false,
            ]
        ];
    }

    public static function getTimeOptions()
    {
        $result = [];

        foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23] as $time) {
            $result[] = $time . ':00';
            $result[] = $time . ':30';
        }

        return $result;
    }

    public static function getDemands()
    {
        return self::get('demands', Demand::all());
    }
}
