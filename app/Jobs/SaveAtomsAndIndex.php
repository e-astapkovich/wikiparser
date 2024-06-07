<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Atom;
use App\Models\IndexModel;

class SaveAtomsAndIndex implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
	 * Массив слов-атомов из одной статьи для сохранения в БД
	 * @var array
	 */
    protected array $atoms;

    /**
	 * Id статьи, к которой относятся атомы
	 * @var int
	 */
    protected int $articleId;

    /**
     * Create a new job instance.
     */
    public function __construct($atoms, $articleId)
    {
        $this->atoms = $atoms;
        $this->articleId = $articleId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->atoms as $word => $quantity) {
            $atom = Atom::firstOrCreate(['word' => $word]);

            $idx = new IndexModel();
            $idx->atom_id = $atom->id;
            $idx->article_id = $this->articleId;
            $idx->quantity = $quantity;

            $idx->save();
        }

    }
}
