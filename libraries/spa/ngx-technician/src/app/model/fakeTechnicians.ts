export const dataTechnicians : any = {
    products_response : [
        {
            'id': 1,
            'name': '#Customer_Name1',
            'data_address' : {
                'address' : 'Some Address Here',
                'contact' : '9665654',
                'case_date' : '23 January 2018',
                'case_no' : '990987',
                'status': 'Responded',
                'status_type': 2,
                'service_zone' : 'West'
            },
            'product' : {
                'brand' : 'Fujioh',
                'model_number' : 'GS99009',
                'model_name' : 'ARG Hood',
                'serial_number' : 'DXSSI0099887-1929380',
            },
            'case_details': 'Something that is said about what’s wrong with their product'
        },
        {
            'id': 2,
            'name': '#Customer_Name2',
            'data_address' : {
                'address' : 'Some Address Here',
                'contact' : '9665654',
                'case_date' : '23 June 2018',
                'case_no' : '990987',
                'status': 'New',
                'status_type': 1,
                'service_zone' : 'West'
            },
            'product' : {
                'brand' : 'Fujioh',
                'model_number' : 'GS99009',
                'model_name' : 'ARG Hood',
                'serial_number' : 'DXSSI0099887-1929380',
            },
            'case_details': 'Something that is said about what’s wrong with their product'
        }
    ],
    products_resolved : [
        {
            'id': 3,
            'name': '#Customer_Name3',
            'data_address' : {
                'address' : 'Some Address Here',
                'contact' : '9665654',
                'case_date' : '23 June 2018',
                'case_no' : '990987',
                'status': 'Closed',
                'status_type': 4,
                'service_zone' : 'West'
            },
            'product' : {
                'brand' : 'Fujioh',
                'model_number' : 'GS99009',
                'model_name' : 'ARG Hood',
                'serial_number' : 'DXSSI0099887-1929380',
            },
            'case_details': 'Something that is said about what’s wrong with their product'
        },
        {
            'id': 4,
            'name': '#Customer_Name4',
            'data_address' : {
                'address' : 'Some Address Here',
                'contact' : '9665654',
                'case_date' : '23 June 2018',
                'case_no' : '990987',
                'status': 'Resolved',
                'status_type': 3,
                'service_zone' : 'West'
            },
            'product' : {
                'brand' : 'Fujioh',
                'model_number' : 'GS99009',
                'model_name' : 'ARG Hood',
                'serial_number' : 'DXSSI0099887-1929380',
            },
            'case_details': 'Something that is said about what’s wrong with their product'
        }
    ],
    detailTechnician: {
        customer: {
            fullname: 'Kenneth',
            contact_no : '+65-98447559',
            email: 'ken@email.com',
            address: '24 lorong ah soo, #03-11',
            postal_code : '426001'
        },
        case_details: {
            case_no : 'MC001',
            data_created: '23 Feb 2018 by CS NAME',
            brand : 'Fujioh',
            model_name : 'GS99009',
            model_number : 'ARG Hood',
            serial_number: 'DXSSI0099887-1929380',
            date_closed : 'N.A',
            technician : '#Technician Name',
            service_zone: '#Service Zone'
        },
        case_notes : [
            {
                id: 1,
                desc: 'Issue resolved. Motor changed.',
                name: 'Technician Name',
                date: '28 April 2018'
            },{
                id: 2,
                desc: 'Was unable to fix issue, motor is spoiled not power issue.',
                name: 'Technician Name',
                date: '26 April 2018'
            }
        ]
    },
    brandList : [
        {
            value: 'Fujioh',
            name: 'Fujioh'
        },{
            value: 'Brand Opt 1',
            name: 'Brand Opt 1'
        },{
            value: 'Brand Opt 2',
            name: 'Brand Opt 2'
        }
    ],
    modelNameList : [
        {
            value: 'ARG Hood',
            name: 'ARG Hood'
        },{
            value: 'Model Name Opt 1',
            name: 'Model Name Opt 1'
        },{
            value: 'Model Name Opt 2',
            name: 'Model Name Opt 2'
        }
    ],
    modelNumberList : [
        {
            value: 'GS99009',
            name: 'GS99009'
        },{
            value: 'GS99100',
            name: 'GS99100'
        },{
            value: 'HS99009',
            name: 'HS99009'
        }
    ]
}
