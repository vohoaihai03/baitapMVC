<?php

namespace App\GraphQL\Resolvers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class MessageResolver
{
    public function resolveMessages($root, array $args, GraphQLContext $context)
    {
        return Message::where('chat_room_id', $args['chat_room_id'])->get();
    }

    public function resolveCreateMessage($root, array $args, GraphQLContext $context)
    {
        $message = new Message();
        $message->user_id = auth()->id();
        $message->chat_room_id = $args['chat_room_id'];
        if (isset($args['message'])) {
            $message->message = $args['message'];
        }

        if (isset($args['image'])) {
            $imagePath = $this->saveImage($args['image']);
            $message->image = $imagePath;
        }

        $message->save();

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }

    protected function saveImage(UploadedFile $image)
    {
        $path = Storage::putFile('images', $image);
        return Storage::url($path);
    }
}
