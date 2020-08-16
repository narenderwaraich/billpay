<div id="showmenu" class="discountSlide">
        <div style="text-align: center; margin-top: 3px;">Add Discount <span><i class="fa fa-remove slideButton" style="color: red; font-size: 20px; margin-left: 20px; margin-top: 2px; position: absolute; cursor: pointer;"></i></span></div>
                        <div style="margin-left: 10px; float: left; width: 120px; color: white; margin-top: 2px" class="menu">
                          <input onclick="document.getElementById('disValueFlat').disabled = false; document.getElementById('disValuePer').disabled = true;" type="radio" name="dis_type" id="flat_radio">
                          <span style="margin-left: 10px;">Flat</span><br>
                          <input onclick="document.getElementById('disValueFlat').disabled = true; document.getElementById('disValuePer').disabled = false;" type="radio" name="dis_type" id="percentage_radio">
                          <span style="margin-left: 10px;">Percentage</span> <br>
                          </div>
                          <div>
                            <span><input type="text" name="disValueFlat" placeholder="0" id="disValueFlat" onkeyup="myFunction()" style="width: 30%; color: black; margin-top: 4px; height: 22px;" disabled="disabled" /></span>
                          <span>
                            <input type="text" name="disValuePer" placeholder="0" id="disValuePer" onkeyup="myFunction()" style="width: 20%; color: black; margin-top: 4px; height: 22px;" disabled="disabled" /><span>&nbsp; %</span>
                           <!-- <select name="disValuePer" id="disValuePer" onchange="myFunction()" style="width: 30%;  margin-top: 4px; color:black;" disabled="disabled">
                                  <option value="">select</option>
                                  <option value="10">10%</option>
                                  <option value="15">15%</option>
                                  <option value="20">20%</option>
                                  <option value="25">25%</option>
                                  <option value="35">35%</option>
                                  <option value="50">50%</option>
                                  <option value="60">60%</option>
                                  <option value="70">70%</option>
                              </select> -->
                          </span>
                           </div>
                    </div>  



                 <div id="showmenu2" class="taxSlide">
                  <div style="text-align: center; margin-top: 3px;">Add Taxes<span><i class="fa fa-remove slideButton2" style="color: red; font-size: 20px; margin-left: 35px; margin-top: 2px; position: absolute; cursor: pointer;"></i></span> </div>
                        <div style="margin-left: 10px; float: left; width: 120px; color: white; margin-top: 2px" class="menu2">
                          <input onclick="document.getElementById('taxValueFlat').disabled = false; document.getElementById('taxValuePer').disabled = true;" type="radio" name="tax_type"  id="tax_flat_radio">
                          <span style="margin-left: 10px;">Flat</span>  <br>
                          <input onclick="document.getElementById('taxValueFlat').disabled = true; document.getElementById('taxValuePer').disabled = false;" type="radio" name="tax_type" id="tax_per_radio">
                          <span style="margin-left: 10px;">Percentage</span> <br>
                          </div>
                          <div>
                            <span><input type="text" name="taxValueFlat" placeholder="0" id="taxValueFlat" onkeyup="myFunction()" style="width: 30%; color: black; margin-top: 4px; height: 22px;" disabled="disabled" /></span>
                          <span>
                            <input type="text" name="taxValuePer" placeholder="0" id="taxValuePer" onkeyup="myFunction()" style="width: 20%; color: black; margin-top: 4px; height: 22px;" disabled="disabled" /><span>&nbsp; %</span>
                      <!--    <select name="taxValuePer" id="taxValuePer" onchange="myFunction()" style="width: 30%;  margin-top: 4px; color:black;" disabled="disabled">
                            <option value="">select</option>
                            <option value="5">5%</option>
                            <option value="7">7%</option>
                            <option value="9">9%</option>
                            <option value="10">10%</option>
                            <option value="12">12%</option>
                            <option value="15">15%</option>
                          </select> -->
                          </span>
                           </div>
                      </div> 


                      <div id="showmenu" class="discountSlide">
                                      <div style="text-align: center; margin-top: 3px;">Add Discount 
                                            <span>
                                              <i class="fa fa-remove slideButton" style="color: red; font-size: 20px; margin-left: 20px; margin-top: 2px; position: absolute; cursor: pointer;"></i>
                                            </span>
                                      </div>

                                      <div style="margin-left: 10px; float: left; width: 120px; color: white; margin-top: 2px" class="menu">
                                                <input onclick="document.getElementById('disValueFlat').disabled = false; document.getElementById('disValuePer').disabled = true;" type="radio" name="dis_type" id="flat_radio">
                                            <span style="margin-left: 10px;">Flat</span>
                                            <br>
                                                <input onclick="document.getElementById('disValueFlat').disabled = true; document.getElementById('disValuePer').disabled = false;" type="radio" name="dis_type" id="percentage_radio">
                                            <span style="margin-left: 10px;">Percentage</span> 
                                            <br>
                                      </div>
                                      <div>
                                        <span>
                                          <input type="text" name="disValueFlat" placeholder="0" id="disValueFlat" onkeyup="myFunction()" style="width: 30%; color: black; margin-top: 4px; height: 22px;" disabled="disabled" />
                                        </span>
                                      <span>
                                        <input type="text" name="disValuePer" value="{{$inv->disValuePer}}" placeholder="0" id="disValuePer" onkeyup="myFunction()" onchange="myFunction()"   style="width: 20%; color: black; margin-top: 4px; height: 22px;" disabled="disabled" />
                                        <span>&nbsp; %</span>
                                       <!-- <select name="disValuePer" id="disValuePer" onchange="myFunction()" style="width: 30%;  margin-top: 4px; color:black;" disabled="disabled">
                                              <option value="">select</option>
                                              <option value="10">10%</option>
                                              <option value="15">15%</option>
                                              <option value="20">20%</option>
                                              <option value="25">25%</option>
                                              <option value="35">35%</option>
                                              <option value="50">50%</option>
                                              <option value="60">60%</option>
                                              <option value="70">70%</option>
                                          </select> -->
                                      </span>
                                       </div>
                                </div>  



                                 <div id="showmenu2" class="taxSlide">
                                  <div style="text-align: center; margin-top: 3px;">Add Taxes<span><i class="fa fa-remove slideButton2" style="color: red; font-size: 20px; margin-left: 35px; margin-top: 2px; position: absolute; cursor: pointer;"></i></span> </div>
                                        <div style="margin-left: 10px; float: left; width: 120px; color: white; margin-top: 2px" class="menu2">
                                          <input onclick="document.getElementById('taxValueFlat').disabled = false; document.getElementById('taxValuePer').disabled = true;" type="radio" name="tax_type" id="tax_flat_radio">
                                          <span style="margin-left: 10px;">Flat</span>  <br>
                                          <input onclick="document.getElementById('taxValueFlat').disabled = true; document.getElementById('taxValuePer').disabled = false;" type="radio" name="tax_type" id="tax_per_radio">
                                          <span style="margin-left: 10px;">Percentage</span> <br>
                                          </div>
                                          <div>
                                            <span><input type="text" name="taxValueFlat" placeholder="0" id="taxValueFlat" onkeyup="myFunction()" style="width: 30%; color: black; margin-top: 4px; height: 22px;" disabled="disabled" /></span>
                                          <span>
                                            <input type="text" name="taxValuePer" value="{{$inv->taxValuePer}}" placeholder="0" id="taxValuePer" onkeyup="myFunction()" onchange="myFunction()" style="width: 20%; color: black; margin-top: 4px; height: 22px;" disabled="disabled" /><span>&nbsp; %</span>
                                      <!--    <select name="taxValuePer" id="taxValuePer" onchange="myFunction()" style="width: 30%;  margin-top: 4px; color:black;" disabled="disabled">
                                            <option value="">select</option>
                                            <option value="5">5%</option>
                                            <option value="7">7%</option>
                                            <option value="9">9%</option>
                                            <option value="10">10%</option>
                                            <option value="12">12%</option>
                                            <option value="15">15%</option>
                                          </select> -->
                                          </span>
                                           </div>
                                    </div> 