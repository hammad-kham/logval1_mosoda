<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqTopic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\AppUser;

class FaqTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $answer = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';

        for($i=1;$i<=5;$i++) {

            $title = 'FAQ Topic '.$i;
            $type = 1;
            $has_faqs = 1;

            {

                $has_subcategories = 1;

                $topic_id = $this->faq_topic($title, $type, $has_faqs);


                //sub categories of category

                {

                    $question = 'Question 1 of Topic '.$i;

                    $sub_cat_id = $this->faq($topic_id, $question, $answer);




                    $question = 'Question 2 of Topic '.$i;

                    $sub_cat_id = $this->faq($topic_id, $question, $answer);




                    $question = 'Question 3 of Topic '.$i;

                    $sub_cat_id = $this->faq($topic_id, $question, $answer);

                }

            }
        }

    }

    public function faq_topic($title, $type,$has_faqs)

    {
        $title = ltrim(rtrim($title));

        $model = new FaqTopic();

        $model->title = $title;

        $model->type = $type;

        $model->has_faqs = $has_faqs;

        $model->status = 1;

        $model->save();

        $id = $model->id;

        return $id;

    }

    public function faq($topic_id, $question, $answer)

    {
        $question = ltrim(rtrim($question));
        $answer = ltrim(rtrim($answer));

        $model = new Faq();

        $model->topic_id = $topic_id;

        $model->question = $question;

        $model->answer = $answer;

        $model->visits = 0;

        $model->status = 1;

        $model->save();

        $id = $model->id;

        return $id;

    }
}