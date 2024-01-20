export const sidebarValues:object = {
  'status': [
    {
      'name': 'Summary status',
      'url': '/status',
    },
    {
      'name': 'Active devices',
      'url': '/status/activeDevices',
    },
    {
      'name': 'Active faults',
      'url': '/status/activeFaults',
    }
  ],
  'control': [
    {
      'name': 'Main Power',
      'url': '/control',
    },
    {
      'name':
        'Motherboards <br>& Carrierboards',
      'url':
        '/control/controlDevices',
    }
    ,
    {
      'name':
        'MB/CB <br> Temperature',
      'url':
        '/control/controlDevicesTemperature',
    }
  ],
  'cpus': [
    {
      'name': 'Status control',
      'url': '/cpus',
    },
    {
      'name':
        'Temperature',
      'url':
        '/cpus/temperature',
    }
    ,
  ],
  'cooling': [
    {
      'name': 'Temperature',
      'url': '/cooling',
    },
    {
      'name':
        'FANs',
      'url':
        '/cooling/fans',
    }
    ,
  ],
  'switch': [
    {
      'name': 'Status control',
      'url': '/switch',
    },
    {
      'name':
        'Debug',
      'url':
        '/switch/debug',
    }
    ,
  ],
  'controller': [
    {
      'name': 'Status control',
      'url': '/controller',
    },
    {
      'name':
        'Debug',
      'url':
        '/controller/debug',
    }
    ,
  ],
  'admin': [
    {
      'name': 'Backup',
      'url': '/admin',
    },
    {
      'name':
        'Support',
      'url':
        '/admin/support',
    }
    ,
    {
      'name':
        'Users',
      'url':
        '/admin/users',
    }
    ,
    {
      'name':
        'Firmware upgrade',
      'url':
        '/admin/upgrade',
    }
    ,
    {
      'name':
        'Logs',
      'url':
        '/admin/logs',
    }
    ,
  ]
}
