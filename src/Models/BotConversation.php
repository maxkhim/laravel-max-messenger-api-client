<?php

namespace Maxkhim\MaxMessengerApiClient\Models;

use Illuminate\Database\Eloquent\Model;
use Maxkhim\MaxMessengerApiClient\Bot\Dialogs\AbstractDialog;

class BotConversation extends Model
{
    /**
     * Название таблицы
     *
     * @var string
     */
    protected $table = 'maxbot_conversations';

    public const CONVERSATION_TYPE_COMMAND = 'command';
    public const CONVERSATION_TYPE_DIALOG = 'interactive';
    /**
     * Массово назначаемые атрибуты
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'chat_id',
        'chat_type',
        'conversation_type',
        'context_data',
        'current_state',
        'current_dialog_code',
        'current_dialog_key',
        'is_active',
        'started_at',
        'ended_at',
        'metadata',
        'class',
    ];

    /**
     * Атрибуты, которые должны быть скрыты при сериализации
     *
     * @var array<string>
     */
    protected $hidden = [];

    /**
     * Типы атрибутов для приведения типов
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'chat_id' => 'string',
        'chat_type' => 'string',
        'conversation_type' => 'string',
        'context_data' => 'array',
        'current_state' => 'string',
        'current_dialog_code' => 'string',
        'current_dialog_key' => 'string',
        'is_active' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'metadata' => 'array', // JSON/TEXT данные как массив
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function save(array $options = [])
    {
        $this->conversation_type = $this->getConversationType();
        return parent::save($options);
    }

    private function getConversationType(): string
    {
        $res = self::CONVERSATION_TYPE_COMMAND;
        $className = $this->class;
        if (class_exists($className) && (new \ReflectionClass($className))->isSubclassOf(AbstractDialog::class)) {
            $res = self::CONVERSATION_TYPE_DIALOG;
        }

        return $res;
    }
}
