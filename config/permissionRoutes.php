<?php

return [
    'configurable_routes' => [
        ROUTE_SECTION_APPLICATION_MANAGEMENTS => [
            ROUTE_SUB_SECTION_ADMIN_SETTINGS => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin-settings.index',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin-settings.edit',
                    'admin-settings.update',
                ],
            ],
            'dashboard' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'dashboard'
                ]
            ],
            'log_viewer' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'logs.index'
                ]
            ],
            'audits' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'audits.index'
                ]
            ],
            'system_notice' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'system-notices.index',
                    'system-notices.show'
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'system-notices.create',
                    'system-notices.store'
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'system-notices.edit',
                    'system-notices.update',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'system-notices.destroy',
                ]
            ],
            'id_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.id-management.index',
                    'admin.id-management.show',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.id-management.approve',
                    'admin.id-management.decline',
                ],
            ],
            'stock_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.stock-items.index',
                    'admin.stock-items.show'
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'admin.stock-items.create',
                    'admin.stock-items.store'
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.stock-items.edit',
                    'admin.stock-items.update',
                    'admin.stock-items.toggle-status',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'admin.stock-items.destroy',
                ]
            ],
            'stock_pair_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.stock-pairs.index',
                    'admin.stock-pairs.show'
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'admin.stock-pairs.create',
                    'admin.stock-pairs.store',
                    'admin.stock-pairs.multiStore',
                    'admin.stock-pairs.multiIndex',
                    // 'admin.list-bank.index',
                    // 'admin.list-bank.create',
                    // 'admin.list-bank.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.stock-pairs.edit',
                    'admin.stock-pairs.update',
                    // 'admin.list-bank.edit',
                    // 'admin.list-bank.update',
                    'admin.stock-pairs.toggle-status',
                    'admin.stock-pairs.make-status-default',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'admin.stock-pairs.destroy',
                    // 'admin.list-bank.destroy',
                ]
            ],
            'list_bank_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.list-bank.index',
                    'admin.list-bank.show',
                    'admin.bank-list-trader.index',
                ],

                ROUTE_GROUP_CREATION_ACCESS => [
                    'admin.list-bank.create',
                    'admin.list-bank.store',
                ],

                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.list-bank.edit',
                    'admin.list-bank.update',
                ],

                ROUTE_GROUP_DELETION_ACCESS => [
                    'admin.list-bank.destroy',
                ]
            ],

            'rpc_list' =>[

                ROUTE_GROUP_READER_ACCESS => [
                    'rpcport.index',
                ],

                 ROUTE_GROUP_CREATION_ACCESS => [
                    'rpcport.create',
                    'rpcport.store',
                ],
                  ROUTE_GROUP_MODIFIER_ACCESS => [
                    'rpcport.edit',
                    'rpcport.update',
                ],

                ROUTE_GROUP_DELETION_ACCESS => [
                    'rpcport.destroy',
                ]

            ],
            'bonus_management' => [
                ROUTE_GROUP_CREATION_ACCESS => [
                    'admin.bonuses.create',
                    'admin.bonuses.store',
                ]
            ],
            'review_withdrawals' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.review-withdrawals.index',
                    'admin.review-withdrawals.show',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.review-withdrawals.approve',
                    'admin.review-withdrawals.decline',
                    'admin.review-withdrawals.declineBank',
                    'admin.review-withdrawals.approveBank',
                ],
            ],
            'modify_wallets' => [
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.users.wallets.edit',
                    'admin.users.wallets.update',
                    'admin.users.wallets.editBankBalance',
                    'admin.users.wallets.updateDepoBank',
                    'admin.users.wallets.declineDepositBank',
                ],
            ],
            'transaction_reports' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'reports.admin.all-deposits',
                    'reports.admin.wallets.deposits',
                    'reports.admin.all-withdrawals',
                    'reports.admin.wallets.withdrawals',
                    'reports.admin.allTrades',
                    'reports.admin.trades',
                    'reports.admin.open-orders',
                    'reports.admin.stock-pairs.trades',
                    'reports.admin.stock-pairs.open-orders',
                    'reports.admin.transaction.all-users',
                    'reports.admin.transaction.user',
                    // 'reports.trader.deposits-bank'
                ],
                'transaction_bank_reports' => [

                    'reports.admin.all-deposits-bank',
                    'reports.admin.wallets.depositsBank',

                ],

                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'complete-bank-deposit',
                    'change.status.bankDepo'
                ],
            ],


            'menu_manager' => [
                ROUTE_GROUP_FULL_ACCESS => [
                    'menu-manager.index',
                    'menu-manager.save',
                ],
            ],
        ],
        ROUTE_SECTION_USER_MANAGEMENTS => [
            ROUTE_SUB_SECTION_USERS => [
                ROUTE_GROUP_READER_ACCESS => [
                    'users.index',
                    'users.show',
                    'admin.users.wallets',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'users.create',
                    'users.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'users.edit',
                    'users.update',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'users.update.status',
                    'users.edit.status',
                ],
            ],
            ROUTE_SUB_SECTION_ROLE_MANAGEMENTS => [
                ROUTE_GROUP_READER_ACCESS => [
                    'user-role-managements.index',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'user-role-managements.create',
                    'user-role-managements.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'user-role-managements.edit',
                    'user-role-managements.update',
                    'user-role-managements.status',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'user-role-managements.destroy',
                ],
            ]
        ],

        ROUTE_SECTION_TRADE_ANALYST => [
            'posts' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'trade-analyst.posts.index',
                    'trade-analyst.posts.show'
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'trade-analyst.posts.create',
                    'trade-analyst.posts.store'
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'trade-analyst.posts.edit',
                    'trade-analyst.posts.update',
                    'trade-analyst.posts.toggle-status',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'trade-analyst.posts.destroy',
                ]
            ],

            'questions' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'trade-analyst.questions.index'
                ],
                'answer_access' => [
                    'trade-analyst.questions.answer',
                ],
                'delete_access' => [
                    'trade-analyst.questions.destroy',
                ],
            ]
        ],

        ROUTE_SECTION_TRADER => [
            'orders' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'exchange.ico.index',
                    'exchange.ico.indexFrontEnd',
                    'reports.trader.trades',
                    'trader.orders.open-orders',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'trader.orders.store',
                    'exchange.ico.buy',
                    'exchange.ico.store',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'trader.orders.destroy',
                    'trader.order.delete',
                ],
            ],
            'wallets' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'trader.wallets.index',

                ],
                'deposit_access' => [
                    'trader.wallets.deposit',
                    'trader.wallets.deposit.store',
                    'reports.trader.all-deposits',
                    'reports.trader.deposits',
                ],
                'deposit_bank_access' => [
                    'reports.trader.deposits-bank',
                    'trader.wallets.deposit.storeBank',
                    'reports.trader.all-deposits-bank',
                    'trader.wallets.deposit.struckUpload',
                    'trader.wallets.invoice',

                ],
                'withdrawal_access' => [
                    'trader.wallets.withdrawal',
                    'trader.wallets.withdrawal.store',
                    'reports.trader.all-withdrawals',
                    'reports.trader.withdrawals',
                ],
            ],
            'referral' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'reports.trader.referral',
                    'reports.trader.referral-earning',
                    'profile.referral',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'profile.referral.generate',
                    'profile.trader-bank.create',
                    'profile.trader-bank.store'
                ],
            ],
            'bank-trader' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'trader.trader-bank.index',

                ],

                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'trader.trader-bank.edit',
                    'trader.trader-bank.update',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'trader.trader-bank.destroy',
                ],
            ],
            'questions' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'trader.questions.index'
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'trader.questions.create',
                    'trader.questions.store'
                ]
            ]
        ]
    ],
    ROUTE_TYPE_AVOIDABLE_MAINTENANCE => [
        'login',
    ],
    ROUTE_TYPE_AVOIDABLE_UNVERIFIED => [],
    ROUTE_TYPE_AVOIDABLE_SUSPENDED => [],
    ROUTE_TYPE_FINANCIAL => [
        'trader.exchange.store',
        'trader.exchange.destroy',
        'trader.wallets.deposit',
        'trader.wallets.withdrawal'
    ],
    ROUTE_TYPE_PRIVATE => [
        'logout',
        'profile.index',
        'profile.edit',
        'profile.update',
        'profile.change-password',
        'profile.update-password',
        'profile.setting',
        'profile.setting.edit',
        'profile.avatar.edit',
        'profile.avatar.update',
        'profile.google-2fa.create',
        'profile.google-2fa.store',
        'profile.google-2fa.verify',
        'profile.google-2fa.destroy',
        'profile.create.bank',
        'profile.store.bank',
        'account.index',
        'account.update',
        'account.logout',
        'notices.index',
        'notices.mark-as-read',
        'notices.mark-all-as-read',
        'notices.mark-as-unread',
        'notices.mark-all-as-read',
        'user_setting.change_password',
        'user_setting.update_password',
        'user_setting.change_pin',
        'user_setting.update_pin',
        'user_setting.get_pin',
        'user_setting.change_avatar',
        'user_setting.upload_avatar',
        'trader.upload-id.index',
        'trader.upload-id.store',
        'exchange.get-my-open-orders',
        'exchange.get-my-trade',
        'exchange.get-wallet-summary',
    ],
];
