<?php

namespace App\Helpers;

class SourceDataFunctions 
{
    public const OFFLINE_SOURCE_TYPE = "Offline";
    public const SOURCE_TYPES_THAT_NOT_SHOW_DETAIL_DATA = [
        self::OFFLINE_SOURCE_TYPE,
    ];

    public static function getInitData()
    {
        return Functions::getJsSourceTypes();
    }

    public static function getChannelBySubChannel($subChannelInput): String
    {
        $data = (array) self::getInitData();

        foreach($data as $sourceType) {
            $channels = (array) $sourceType["values"];

            foreach($channels as $channel) {
                $subchannels = $channel["values"];

                foreach($subchannels as $subChannel) {
                    if (trim(strtolower($subChannelInput)) === trim(strtolower($subChannel))) {
                        return (string) $channel["name"];
                    }
                }
            }
        }

        throw new \Exception("Sub-channel invalid!");
    }

    public static function getSourceTypeByChannel($channelInput)
    {
        $data = (array) self::getInitData();

        foreach($data as $sourceType) {
            $channels = (array) $sourceType["values"];

            foreach($channels as $channel) {
                if (trim(strtolower($channelInput)) === trim(strtolower($channel["name"]))) {
                    return (string) $sourceType["name"];
                }
            }
        }

        throw new \Exception("Channel invalid!");
    }
}