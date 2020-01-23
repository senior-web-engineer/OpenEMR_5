<h3>Axis II Diagnosis</h3>
										<button id="addDiagnosis" class="btn" >Add Axis II</button><br/>
										<ul class="list-unstyled" id="diagnosis_list" >
											<li class="itemList" editortype="diagnosis_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="diagnosis_Description"  disabled></textarea><br/>
											<div data-bind="tiControl: {
																id: 'diagnosis_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['diagnosis_GroupID'] ,
																appendvalue: false,
																params: {id1: 0}
																}, tiVM: $data"></div>
											<span  class="dev" >
												id <input type='text' id='diagnosis_id' />
												GroupID <input type='text' id='diagnosis_GroupID' />
												Description <input type='text' id='diagnosis_Description' />
												LegalCode <input type='text' id='diagnosis_LegalCode' />
																																			</span>
												<input type="hidden" id="diagnosis_Axis" value="1">											
											<div class="clear text-right">
												<button class="btn postdiagnosis" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postdiagnosis" action="save">Save Diagnosis</button>
											</div>
									  </div>
								<h3>Axis III Physical Diorders</h3>
										<button id="addAxisIII" class="btn">Add Axis III</button><br/>
										<ul class="list-unstyled"  id="AxisIII_list" >
											<li class="itemList" editortype="AxisIII_item" recid="1" ></li>
										</ul>
										
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-lg" id="modalitynotes_Notes"  ></textarea><br/>

											<span  class="dev" >
												id <input type='text' id='modalitynotes_id' />
											</span>
											<div class="clear text-right">
												<button class="btn postmodalitynote" action="delete" >Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postmodalitynote" action="save" >Save Modality Note</button>
											</div>		