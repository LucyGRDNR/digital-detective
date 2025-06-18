<?php

return [
    // Global App Titles
    'create_story' => 'Vytvořit příběh',
    'edit_story' => 'Upravit příběh',
    'digital_detective' => 'Digitální Detektiv',
    'no' => 'Ne',
    'yes' => 'Ano', 

    // Story Details
    'story_details' => 'Detaily příběhu',
    'story_name' => 'Název příběhu',
    'story_description' => 'Popis',
    'story_main_image' => 'Hlavní obrázek příběhu',
    'current_story_image' => 'Aktuální obrázek příběhu',
    'story_place' => 'Místo',
    'story_place_gps_optional' => 'GPS Místa (Volitelné)',
    'story_distance_km' => 'Vzdálenost (v km)',
    'story_estimated_time_minutes' => 'Odhadovaný čas (v minutách)',

    // Chapters
    'chapter' => 'Kapitola',
    'chapter_title' => 'Název kapitoly',
    'chapter_content' => 'Obsah kapitoly',
    'chapter_upload_image_optional' => 'Nahrát obrázek kapitoly (Volitelné)',
    'current_image' => 'Aktuální obrázek',
    'delete_image' => 'Smazat obrázek',
    'is_end_chapter' => 'Je toto konec příběhu?',
    'next_chapter_title' => 'Další kapitola (Název)',
    'add_question' => 'Přidat otázku?',
    'question_details' => 'Detaily otázky',
    'question_text' => 'Text otázky',
    'question_hint_optional' => 'Nápověda (Volitelné)',
    'answer_type' => 'Typ odpovědi',
    'select_answer_type' => '-- Vyberte typ odpovědi --',
    'answer_type_text' => 'Text',
    'answer_type_number' => 'Číslo',
    'answer_type_multiple_choice' => 'Více možností',
    'correct_answer' => 'Správná odpověď',
    'options_max_5' => 'Možnosti (Maximálně 5)',
    'add_option' => 'Přidat možnost',
    'wrong_answer_feedback' => 'Zpětná vazba pro špatnou odpověď',
    'delete_chapter' => 'Smazat kapitolu',

    // Buttons and Actions
    'add_chapter_button' => 'Přidat kapitolu',
    'save_changes_button' => 'Uložit změny',
    'save_story_button' => 'Uložit příběh',
    'delete_story_button' => 'Smazat příběh',
    'confirm_delete_story' => 'Opravdu chcete tento příběh smazat? Tato akce je nevratná.',
    'remove_option' => 'Odstanit možnost',

    // Placeholders
    'option_text_placeholder' => 'Text možnosti',
    'go_to_chapter' => 'Přejít na kapitolu',
    'select_chapter' => '-- Vyberte kapitolu --',

    // Dynamic Chapter Display
    'ends_story' => 'Ukončuje příběh',
    'branches_with_question' => 'Větvení pomocí otázky',
    'follows_chapter' => 'Následuje kapitola:',
    'unselected_chapter' => 'Zatím nevybráno',

    // JavaScript Validation Messages (for `edit.js` and `create.js`)
    'validation_story_name_required' => 'Prosím zadejte název příběhu.',
    'validation_story_description_required' => 'Prosím zadejte popis příběhu.',
    'validation_image_required' => 'Prosím nahrajte hlavní obrázek příběhu.',
    'validation_story_place_required' => 'Prosím zadejte místo konání.',
    'validation_distance_required' => 'Zadejte vzdálenost (alespoň 0).',
    'validation_time_required' => 'Zadejte čas (alespoň 0).',
    'validation_chapter_title_required' => 'Prosím zadejte název kapitoly.',
    'validation_chapter_content_required' => 'Prosím zadejte obsah kapitoly.',
    'validation_next_chapter_required' => 'Prosím vyberte následující kapitolu nebo kapitolu označte jako konečnou.',
    'validation_question_text_required' => 'Otázka: Prosím zadejte text otázky.',
    'validation_feedback_required' => 'Otázka: Prosím zadejte zpětnou vazbu.',
    'validation_answer_type_required' => 'Prosím zadejte typ odpovědi.',
    'validation_correct_answer_required' => 'Prosím zadejte správnou odpověď.',
    'validation_answer_must_be_number' => 'Odpověď musí být ve formě čísla.',
    'validation_option_text_required' => 'Prosím zadejte text možnosti.',
    'validation_option_next_chapter_required' => 'Prosím vyberte následující kapitolu.',
    'confirm_delete_chapter' => 'Opravdu chcete smazat tuto kapitolu?',
    'confirm_delete_option' => 'Jste si jisti, že chcete tuto možnost smazat?',
];
