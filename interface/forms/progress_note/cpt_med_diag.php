<?php
		//$invalid_diag = "'F80','F84','ICD10:G00.0'";
	  $valid_medicaid_diag = "	'ICD10:F06.32'
						'ICD10:F01.51'
						'ICD10:F01.51',
						'ICD10:F02.80',
						'ICD10:F02.81',
						'ICD10:F03.90',
						'ICD10:F03.91',
						'ICD10:F04',
						'ICD10:F05',
						'ICD10:F06.0',
						'ICD10:F06.1',
						'ICD10:F06.30',
						'ICD10:F06.31',
						'ICD10:F06.32',
						'ICD10:F06.33',
						'ICD10:F06.34',
						'ICD10:F06.4',
						'ICD10:F06.8',
						'ICD10:F07.0',
						'ICD10:F07.81',
						'ICD10:F07.89',
						'ICD10:F07.9',
						'ICD10:F09',
						'ICD10:F10.10',
						'ICD10:F10.120',
						'ICD10:F10.121',
						'ICD10:F10.129',
						'ICD10:F10.14',
						'ICD10:F10.150',
						'ICD10:F10.151',
						'ICD10:F10.159',
						'ICD10:F10.180',
						'ICD10:F10.181',
						'ICD10:F10.182',
						'ICD10:F10.188',
						'ICD10:F10.19',
						'ICD10:F10.20',
						'ICD10:F10.21',
						'ICD10:F10.220',
						'ICD10:F10.221',
						'ICD10:F10.229',
						'ICD10:F11.10',
						'ICD10:F11.120',
						'ICD10:F11.129',
						'ICD10:F11.20',
						'ICD10:F11.21',
						'ICD10:F11.220',
						'ICD10:F11.221',
						'ICD10:F11.222',
						'ICD10:F11.229',
						'ICD10:F11.23',
						'ICD10:F11.24',
						'ICD10:F11.250',
						'ICD10:F11.251',
						'ICD10:F11.259',
						'ICD10:F11.281',
						'ICD10:F11.282',
						'ICD10:F11.288',
						'ICD10:F11.29',
						'ICD10:F11.90',
						'ICD10:F12.10',
						'ICD10:F12.20',
						'ICD10:F12.21',
						'ICD10:F12.220',
						'ICD10:F12.221',
						'ICD10:F12.222',
						'ICD10:F12.229',
						'ICD10:F12.250',
						'ICD10:F12.251',
						'ICD10:F12.259',
						'ICD10:F12.280',
						'ICD10:F12.288',
						'ICD10:F12.29',
						'ICD10:F12.90',
						'ICD10:F13.10',
						'ICD10:F13.120',
						'ICD10:F13.20',
						'ICD10:F13.21',
						'ICD10:F13.220',
						'ICD10:F13.221',
						'ICD10:F13.229',
						'ICD10:F13.230',
						'ICD10:F13.231',
						'ICD10:F13.232',
						'ICD10:F13.239',
						'ICD10:F13.24',
						'ICD10:F13.250',
						'ICD10:F13.251',
						'ICD10:F13.259',
						'ICD10:F13.26',
						'ICD10:F13.27',
						'ICD10:F13.280',
						'ICD10:F13.281',
						'ICD10:F13.282',
						'ICD10:F13.288',
						'ICD10:F13.29',
						'ICD10:F13.90',
						'ICD10:F14.10',
						'ICD10:F14.120',
						'ICD10:F14.20',
						'ICD10:F14.21',
						'ICD10:F14.220',
						'ICD10:F14.221',
						'ICD10:F14.222',
						'ICD10:F14.229',
						'ICD10:F14.23',
						'ICD10:F14.24',
						'ICD10:F14.250',
						'ICD10:F14.251',
						'ICD10:F14.259',
						'ICD10:F14.280',
						'ICD10:F14.281',
						'ICD10:F14.282',
						'ICD10:F14.288',
						'ICD10:F14.29',
						'ICD10:F14.90',
						'ICD10:F15.10',
						'ICD10:F15.120',
						'ICD10:F15.20',
						'ICD10:F15.21',
						'ICD10:F15.220',
						'ICD10:F15.221',
						'ICD10:F15.222',
						'ICD10:F15.229',
						'ICD10:F15.23',
						'ICD10:F15.24',
						'ICD10:F15.250',
						'ICD10:F15.251',
						'ICD10:F15.259',
						'ICD10:F15.280',
						'ICD10:F15.281',
						'ICD10:F15.282',
						'ICD10:F15.288',
						'ICD10:F15.29',
						'ICD10:F15.90',
						'ICD10:F16.10',
						'ICD10:F16.120',
						'ICD10:F16.20',
						'ICD10:F16.21',
						'ICD10:F16.220',
						'ICD10:F16.221',
						'ICD10:F16.229',
						'ICD10:F16.24',
						'ICD10:F16.250',
						'ICD10:F16.251',
						'ICD10:F16.259',
						'ICD10:F16.280',
						'ICD10:F16.283',
						'ICD10:F16.288',
						'ICD10:F16.29',
						'ICD10:F16.90',
						'ICD10:F17.200',
						'ICD10:F17.201',
						'ICD10:F17.210',
						'ICD10:F17.211',
						'ICD10:F17.220',
						'ICD10:F17.221',
						'ICD10:F17.290',
						'ICD10:F17.291',
						'ICD10:F18.10',
						'ICD10:F18.120',
						'ICD10:F18.20',
						'ICD10:F18.21',
						'ICD10:F18.220',
						'ICD10:F18.221',
						'ICD10:F18.229',
						'ICD10:F18.24',
						'ICD10:F18.250',
						'ICD10:F18.251',
						'ICD10:F18.259',
						'ICD10:F18.27',
						'ICD10:F18.280',
						'ICD10:F18.288',
						'ICD10:F18.29',
						'ICD10:F18.90',
						'ICD10:F19.10',
						'ICD10:F19.120',
						'ICD10:F19.20',
						'ICD10:F19.21',
						'ICD10:F19.220',
						'ICD10:F19.221',
						'ICD10:F19.222',
						'ICD10:F19.229',
						'ICD10:F19.230',
						'ICD10:F19.231',
						'ICD10:F19.232',
						'ICD10:F19.239',
						'ICD10:F19.24',
						'ICD10:F19.250',
						'ICD10:F19.251',
						'ICD10:F19.259',
						'ICD10:F19.26',
						'ICD10:F19.27',
						'ICD10:F19.280',
						'ICD10:F19.281',
						'ICD10:F19.282',
						'ICD10:F19.288',
						'ICD10:F19.29',
						'ICD10:F19.90',
						'ICD10:F20.0',
						'ICD10:F20.1',
						'ICD10:F20.2',
						'ICD10:F20.3',
						'ICD10:F20.5',
						'ICD10:F20.81',
						'ICD10:F20.89',
						'ICD10:F21',
						'ICD10:F22',
						'ICD10:F23',
						'ICD10:F24',
						'ICD10:F25.0',
						'ICD10:F25.1',
						'ICD10:F25.8',
						'ICD10:F30.10',
						'ICD10:F30.11',
						'ICD10:F30.12',
						'ICD10:F30.13',
						'ICD10:F30.2',
						'ICD10:F30.3',
						'ICD10:F30.4',
						'ICD10:F30.8',
						'ICD10:F31.0',
						'ICD10:F31.10',
						'ICD10:F31.11',
						'ICD10:F31.12',
						'ICD10:F31.13',
						'ICD10:F31.2',
						'ICD10:F31.30',
						'ICD10:F31.31',
						'ICD10:F31.32',
						'ICD10:F31.4',
						'ICD10:F31.5',
						'ICD10:F31.60',
						'ICD10:F31.61',
						'ICD10:F31.62',
						'ICD10:F31.63',
						'ICD10:F31.64',
						'ICD10:F31.81',
						'ICD10:F31.89',
						'ICD10:F32.0',
						'ICD10:F32.1',
						'ICD10:F32.2',
						'ICD10:F32.3',
						'ICD10:F32.4',
						'ICD10:F32.5',
						'ICD10:F32.81',
						'ICD10:F32.89',
						'ICD10:F33.0',
						'ICD10:F33.1',
						'ICD10:F33.2',
						'ICD10:F33.3',
						'ICD10:F33.40',
						'ICD10:F33.41',
						'ICD10:F33.42',
						'ICD10:F33.8',
						'ICD10:F34.0',
						'ICD10:F34.1',
						'ICD10:F34.81',
						'ICD10:F34.89',
						'ICD10:F40.01',
						'ICD10:F40.02',
						'ICD10:F40.10',
						'ICD10:F40.11',
						'ICD10:F40.210',
						'ICD10:F40.218',
						'ICD10:F40.220',
						'ICD10:F40.228',
						'ICD10:F40.230',
						'ICD10:F40.231',
						'ICD10:F40.232',
						'ICD10:F40.233',
						'ICD10:F40.240',
						'ICD10:F40.241',
						'ICD10:F40.242',
						'ICD10:F40.243',
						'ICD10:F40.248',
						'ICD10:F40.290',
						'ICD10:F40.291',
						'ICD10:F40.298',
						'ICD10:F40.8',
						'ICD10:F41.0',
						'ICD10:F41.1',
						'ICD10:F41.3',
						'ICD10:F41.8',
						'ICD10:F42.2',
						'ICD10:F42.3',
						'ICD10:F42.4',
						'ICD10:F42.8',
						'ICD10:F42.9',
						'ICD10:F43.0',
						'ICD10:F43.10',
						'ICD10:F43.11',
						'ICD10:F43.12',
						'ICD10:F43.20',
						'ICD10:F43.21',
						'ICD10:F43.22',
						'ICD10:F43.23',
						'ICD10:F43.24',
						'ICD10:F43.25',
						'ICD10:F43.29',
						'ICD10:F43.8',
						'ICD10:F44.0',
						'ICD10:F44.1',
						'ICD10:F44.2',
						'ICD10:F44.4',
						'ICD10:F44.5',
						'ICD10:F44.6',
						'ICD10:F44.7',
						'ICD10:F44.81',
						'ICD10:F44.89',
						'ICD10:F45.0',
						'ICD10:F45.1',
						'ICD10:F45.20',
						'ICD10:F45.21',
						'ICD10:F45.22',
						'ICD10:F45.29',
						'ICD10:F45.41',
						'ICD10:F45.42',
						'ICD10:F45.8',
						'ICD10:F48.1',
						'ICD10:F48.2',
						'ICD10:F48.8',
						'ICD10:F50.00',
						'ICD10:F50.01',
						'ICD10:F50.02',
						'ICD10:F50.2',
						'ICD10:F50.81',
						'ICD10:F50.89',
						'ICD10:F51.01',
						'ICD10:F51.02',
						'ICD10:F51.03',
						'ICD10:F51.04',
						'ICD10:F51.05',
						'ICD10:F51.09',
						'ICD10:F51.11',
						'ICD10:F51.12',
						'ICD10:F51.13',
						'ICD10:F51.19',
						'ICD10:F51.3',
						'ICD10:F51.4',
						'ICD10:F51.5',
						'ICD10:F51.8',
						'ICD10:F52.0',
						'ICD10:F52.1',
						'ICD10:F52.21',
						'ICD10:F52.22',
						'ICD10:F52.31',
						'ICD10:F52.32',
						'ICD10:F52.4',
						'ICD10:F52.5',
						'ICD10:F52.6',
						'ICD10:F52.8',
						'ICD10:F53',
						'ICD10:F54',
						'ICD10:F55.0',
						'ICD10:F55.1',
						'ICD10:F55.2',
						'ICD10:F55.3',
						'ICD10:F55.4',
						'ICD10:F55.8',
						'ICD10:F59',
						'ICD10:F60.0',
						'ICD10:F60.1',
						'ICD10:F60.2',
						'ICD10:F60.3',
						'ICD10:F60.4',
						'ICD10:F60.5',
						'ICD10:F60.6',
						'ICD10:F60.7',
						'ICD10:F60.81',
						'ICD10:F60.89',
						'ICD10:F60.9',
						'ICD10:F63.0',
						'ICD10:F63.1',
						'ICD10:F63.2',
						'ICD10:F63.3',
						'ICD10:F63.81',
						'ICD10:F63.89',
						'ICD10:F63.9',
						'ICD10:F64.0',
						'ICD10:F64.1',
						'ICD10:F64.2',
						'ICD10:F64.8',
						'ICD10:F64.9',
						'ICD10:F65.0',
						'ICD10:F65.1',
						'ICD10:F65.2',
						'ICD10:F65.3',
						'ICD10:F65.4',
						'ICD10:F65.50',
						'ICD10:F65.51',
						'ICD10:F65.52',
						'ICD10:F65.81',
						'ICD10:F65.89',
						'ICD10:F65.9',
						'ICD10:F66',
						'ICD10:F68.10',
						'ICD10:F68.11',
						'ICD10:F68.12',
						'ICD10:F68.13',
						'ICD10:F68.8',
						'ICD10:F69',
						'ICD10:F80.0',
						'ICD10:F80.1',
						'ICD10:F80.2',
						'ICD10:F80.81',
						'ICD10:F80.82',
						'ICD10:F82',
						'ICD10:F88',
						'ICD10:F89',
						'ICD10:F90.0',
						'ICD10:F90.1',
						'ICD10:F90.2',
						'ICD10:F90.8',
						'ICD10:F90.9',
						'ICD10:F91.0',
						'ICD10:F91.1',
						'ICD10:F91.2',
						'ICD10:F91.3',
						'ICD10:F91.8',
						'ICD10:F91.9',
						'ICD10:F93.0',
						'ICD10:F93.8',
						'ICD10:F93.9',
						'ICD10:F94.0',
						'ICD10:F94.1',
						'ICD10:F94.2',
						'ICD10:F94.8',
						'ICD10:F94.9',
						'ICD10:F95.0',
						'ICD10:F95.1',
						'ICD10:F95.2',
						'ICD10:F95.8',
						'ICD10:F95.9',
						'ICD10:F98.0',
						'ICD10:F98.1',
						'ICD10:F98.21',
						'ICD10:F98.29',
						'ICD10:F98.3',
						'ICD10:F98.4',
						'ICD10:F98.5',
						'ICD10:F98.8',
						'ICD10:F98.9',
						'ICD10:F99',
						'ICD10:G30.0',
						'ICD10:G30.1',
						'ICD10:G30.8',
						'ICD10:G30.9',
						'ICD10:Z01.818'
						 "
						 ;
		
?>
