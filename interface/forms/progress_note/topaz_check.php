<SCRIPT language="Javascript">

	//test if sigweb is alive
											function SigWebLifeCheck() {
												var xhr = SigWebcreateXHR();
												var prop = 'CompressionMode/1';
												if (xhr) {
													try {
														xhr.open("POST", baseUri + prop, false);
														xhr.send();
														if (xhr.readyState == 4 && xhr.status == 200) {
															//return xhr.responseText;
															return true;
														}
													} catch(err) {
														return false;
													}
												}
												return false;
											}
											if (!SigWebLifeCheck()){	// run the test
												alert('sigweb failure');
											} else {
												alert('sigweb ok');
											}

</script>
