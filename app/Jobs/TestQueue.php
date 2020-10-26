<?php


namespace App\Jobs;


use App\Exceptions\Code;
use App\Exceptions\Msg;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TestQueue implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle() {
        // 插入数据
        Post::create($this->data);
    }
}