<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('acos')
            ->addColumn('parent_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('model', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('foreign_key', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('alias', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('lft', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('rght', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addIndex(
                [
                    'lft',
                    'rght',
                ]
            )
            ->addIndex(
                [
                    'alias',
                ]
            )
            ->create();

        $this->table('activities', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('event_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('speaker_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('track_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('event_places_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('price', 'decimal', [
                'default' => '0.0000',
                'null' => false,
                'precision' => 13,
                'scale' => 4,
            ])
            ->addColumn('type', 'integer', [
                'default' => null,
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'event_id',
                ]
            )
            ->addIndex(
                [
                    'event_places_id',
                ]
            )
            ->addIndex(
                [
                    'speaker_id',
                ]
            )
            ->addIndex(
                [
                    'track_id',
                ]
            )
            ->create();

        $this->table('activity_places', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('activity_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addIndex(
                [
                    'activity_id',
                ]
            )
            ->create();

        $this->table('additional_events', ['id' => false, 'primary_key' => ['super_event_id', 'event_id']])
            ->addColumn('super_event_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('event_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'event_id',
                ]
            )
            ->addIndex(
                [
                    'super_event_id',
                ]
            )
            ->create();

        $this->table('aros')
            ->addColumn('parent_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('model', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('foreign_key', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('alias', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('lft', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('rght', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addIndex(
                [
                    'lft',
                    'rght',
                ]
            )
            ->addIndex(
                [
                    'alias',
                ]
            )
            ->create();

        $this->table('aros_acos')
            ->addColumn('aro_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('aco_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('_create', 'string', [
                'default' => '0',
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('_read', 'string', [
                'default' => '0',
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('_update', 'string', [
                'default' => '0',
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('_delete', 'string', [
                'default' => '0',
                'limit' => 2,
                'null' => false,
            ])
            ->addIndex(
                [
                    'aro_id',
                    'aco_id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'aco_id',
                ]
            )
            ->create();

        $this->table('attendees', ['id' => false, 'primary_key' => ['']])
            ->addColumn('activities_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'activities_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('companies', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('logo', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('site', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addIndex(
                [
                    'name',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'name',
                ]
            )
            ->create();

        $this->table('coupons', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', [
                'default' => null,
                'limit' => 26,
                'null' => false,
            ])
            ->addColumn('event_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('code', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('amount', 'float', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => 'percentage',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('good_thru', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'event_id',
                ]
            )
            ->create();

        $this->table('event_managers', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('event_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'event_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('event_places', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('events_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('ltd', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('lat', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('lng', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addIndex(
                [
                    'events_id',
                ]
            )
            ->create();

        $this->table('events', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('date_start', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP(1)',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('date_end', 'timestamp', [
                'default' => '0000-00-00 00:00:00.0',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('tags', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('type', 'integer', [
                'default' => null,
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('groups')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->create();

        $this->table('not_simultaneous', ['id' => false, 'primary_key' => ['activity_id', 'another_activity_id']])
            ->addColumn('activity_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('another_activity_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'activity_id',
                ]
            )
            ->addIndex(
                [
                    'another_activity_id',
                ]
            )
            ->create();

        $this->table('registration_coupons', ['id' => false, 'primary_key' => ['coupons_id', 'registrations_id']])
            ->addColumn('coupons_id', 'string', [
                'default' => null,
                'limit' => 26,
                'null' => false,
            ])
            ->addColumn('registrations_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'coupons_id',
                ]
            )
            ->addIndex(
                [
                    'registrations_id',
                ]
            )
            ->create();

        $this->table('registration_items', ['id' => false, 'primary_key' => ['registration_id', 'activity_id']])
            ->addColumn('registration_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('activity_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('price', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 13,
                'scale' => 4,
            ])
            ->addIndex(
                [
                    'activity_id',
                ]
            )
            ->addIndex(
                [
                    'registration_id',
                ]
            )
            ->create();

        $this->table('registrations', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('event_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('when', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP(1)',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_paid', 'integer', [
                'default' => '0',
                'limit' => 4,
                'null' => false,
            ])
            ->addColumn('total_paid', 'decimal', [
                'default' => '0.0000',
                'null' => false,
                'precision' => 13,
                'scale' => 4,
            ])
            ->addIndex(
                [
                    'event_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('speakers', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('img_path', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('sponsorships', ['id' => false, 'primary_key' => ['event_id', 'company_id']])
            ->addColumn('event_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('company_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'company_id',
                ]
            )
            ->addIndex(
                [
                    'event_id',
                ]
            )
            ->create();

        $this->table('track_coordinators', ['id' => false, 'primary_key' => ['user_id', 'track_id']])
            ->addColumn('user_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('track_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'track_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('tracks', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('events_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addIndex(
                [
                    'events_id',
                ]
            )
            ->create();

        $this->table('users', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('group_id', 'integer', [
                'default' => '2',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('birthdate', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP(1)',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('tags', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('jti', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('active', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('deleted', 'integer', [
                'default' => null,
                'limit' => 4,
                'null' => true,
            ])
            ->addIndex(
                [
                    'username',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'group_id',
                ]
            )
            ->addIndex(
                [
                    'username',
                ]
            )
            ->addIndex(
                [
                    'password',
                ]
            )
            ->create();

        $this->table('activities')
            ->addForeignKey(
                'event_id',
                'events',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'event_places_id',
                'event_places',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'speaker_id',
                'speakers',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'track_id',
                'tracks',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('activity_places')
            ->addForeignKey(
                'activity_id',
                'activities',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('additional_events')
            ->addForeignKey(
                'event_id',
                'events',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'super_event_id',
                'events',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('attendees')
            ->addForeignKey(
                'activities_id',
                'activities',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('coupons')
            ->addForeignKey(
                'event_id',
                'events',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('event_managers')
            ->addForeignKey(
                'event_id',
                'events',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('event_places')
            ->addForeignKey(
                'events_id',
                'events',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('events')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('not_simultaneous')
            ->addForeignKey(
                'activity_id',
                'activities',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'another_activity_id',
                'activities',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('registration_coupons')
            ->addForeignKey(
                'coupons_id',
                'coupons',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'registrations_id',
                'registrations',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('registration_items')
            ->addForeignKey(
                'activity_id',
                'activities',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'registration_id',
                'registrations',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('registrations')
            ->addForeignKey(
                'event_id',
                'events',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('sponsorships')
            ->addForeignKey(
                'company_id',
                'companies',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'event_id',
                'events',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('track_coordinators')
            ->addForeignKey(
                'track_id',
                'tracks',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('tracks')
            ->addForeignKey(
                'events_id',
                'events',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('users')
            ->addForeignKey(
                'group_id',
                'groups',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('activities')
            ->dropForeignKey(
                'event_id'
            )
            ->dropForeignKey(
                'event_places_id'
            )
            ->dropForeignKey(
                'speaker_id'
            )
            ->dropForeignKey(
                'track_id'
            );

        $this->table('activity_places')
            ->dropForeignKey(
                'activity_id'
            );

        $this->table('additional_events')
            ->dropForeignKey(
                'event_id'
            )
            ->dropForeignKey(
                'super_event_id'
            );

        $this->table('attendees')
            ->dropForeignKey(
                'activities_id'
            )
            ->dropForeignKey(
                'user_id'
            );

        $this->table('coupons')
            ->dropForeignKey(
                'event_id'
            );

        $this->table('event_managers')
            ->dropForeignKey(
                'event_id'
            )
            ->dropForeignKey(
                'user_id'
            );

        $this->table('event_places')
            ->dropForeignKey(
                'events_id'
            );

        $this->table('events')
            ->dropForeignKey(
                'user_id'
            );

        $this->table('not_simultaneous')
            ->dropForeignKey(
                'activity_id'
            )
            ->dropForeignKey(
                'another_activity_id'
            );

        $this->table('registration_coupons')
            ->dropForeignKey(
                'coupons_id'
            )
            ->dropForeignKey(
                'registrations_id'
            );

        $this->table('registration_items')
            ->dropForeignKey(
                'activity_id'
            )
            ->dropForeignKey(
                'registration_id'
            );

        $this->table('registrations')
            ->dropForeignKey(
                'event_id'
            )
            ->dropForeignKey(
                'user_id'
            );

        $this->table('sponsorships')
            ->dropForeignKey(
                'company_id'
            )
            ->dropForeignKey(
                'event_id'
            );

        $this->table('track_coordinators')
            ->dropForeignKey(
                'track_id'
            )
            ->dropForeignKey(
                'user_id'
            );

        $this->table('tracks')
            ->dropForeignKey(
                'events_id'
            );

        $this->table('users')
            ->dropForeignKey(
                'group_id'
            );

        $this->dropTable('acos');
        $this->dropTable('activities');
        $this->dropTable('activity_places');
        $this->dropTable('additional_events');
        $this->dropTable('aros');
        $this->dropTable('aros_acos');
        $this->dropTable('attendees');
        $this->dropTable('companies');
        $this->dropTable('coupons');
        $this->dropTable('event_managers');
        $this->dropTable('event_places');
        $this->dropTable('events');
        $this->dropTable('groups');
        $this->dropTable('not_simultaneous');
        $this->dropTable('registration_coupons');
        $this->dropTable('registration_items');
        $this->dropTable('registrations');
        $this->dropTable('speakers');
        $this->dropTable('sponsorships');
        $this->dropTable('track_coordinators');
        $this->dropTable('tracks');
        $this->dropTable('users');
    }
}
