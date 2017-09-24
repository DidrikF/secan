<template>
	<div>
		<div class="Table">
			<div class="Table__top clear_fix">
				<div>
					<button @click="newBalanceSheet">New Balance Sheet</button>
					<select v-model="denominator" @change="denominationChange">
						<option value="B">Billion</option>
						<option value="M">Million</option>
						<option value="T">Thousand</option>
					</select>
					<input type="range" v-model="columnWidth" min="1" max="10" step="1">
				</div>

				<div>
					<div v-for="(bs, index) in localBalanceSheets" class="Table__column">
						<div class="Table__element">
							<button @click="deleteBalanceSheet(index)">Delete</button>
						</div>
					</div>
				</div>
			</div>
			<div class="Table__sidebar">

			</div>


			<details class="clear_fix">
      			<summary>
      				Current Assets
      			</summary>
				<p>
					<div v-for="(bs, index) in localBalanceSheets" class="Table__column">
						<div class="Table__element">
							<input class="Table__data" v-model="bs.releaseDate.value">
						</div>
						<div class="Table__element">
							<input class="Table__data" v-model="bs.cashAndEquivalents.value">
						</div>
						<div class="Table__element">
							<input class="Table__data" v-model="bs.shortTermInvestments.value">
						</div>
					</div>
				</p>
			</details>
			<div>
				<div v-for="(bs, index) in localBalanceSheets" class="Table__column">
					<div  class="Table__element Collapsable__sum">
						<div v-bind:class="{ 'Table--validationError': validateNumber(bs.currentAssetsSum), 'Table__data': true }">		{{ currentAssetsSumMethod(index) }}
							<!-- some way to create a small div, with a hover property to display the error -->
							<div v-if="bs.currentAssetsSum.error" title="bs.currentAssetsSum.error">x</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>



</template>

<script>
export default {
	data() {
		return {
			denominator: "M",
			columnWidth: 4,
			localBalanceSheets: [{
				//Current Assets:
				releaseDate: {
					value: "",
					error: ""
				},
				cashAndEquivalents: {
					value: 12,
					error: "",
				},
				shortTermInvestments: {
					value: 12,
					error: "",
				},
				netRecievables: {
					value: "",
					error: ""
				},
				inventory: {
					value: "",
					error: ""
				},
				otherCurrentAssets: {
					value: "",
					error: ""
				},
				currentAssetsSum: {
					value: "",
					error: ""
				},
				//Current Liabilities 		//Sub-heading
				accountsPayable: null,
				currentLongTermDebt: null,
				otherCurrentLiabilities: null,
				currentLiabilitiesSum: null,
				//Stockholders Equity		//Sub-heading
				miscStockOptionWarrants: null,
				redeemablePreferredStock: null
			},
			{
				//Current Assets:
				releaseDate: {
					value: "",
					error: ""
				},
				cashAndEquivalents: {
					value: 12,
					error: "",
				},
				shortTermInvestments: {
					value: 12,
					error: "",
				},
				netRecievables: {
					value: "",
					error: ""
				},
				inventory: {
					value: "",
					error: ""
				},
				otherCurrentAssets: {
					value: "",
					error: ""
				},
				currentAssetsSum: {
					value: "",
					error: ""
				},
				//Current Liabilities 		//Sub-heading
				accountsPayable: null,
				currentLongTermDebt: null,
				otherCurrentLiabilities: null,
				currentLiabilitiesSum: null,
				//Stockholders Equity		//Sub-heading
				miscStockOptionWarrants: null,
				redeemablePreferredStock: null
			},]
		}
	},
	computed: {
		
	},
	methods: {
		dropdown(element) {
			console.log(element);
		},
		newBalanceSheet() {
			this.localBalanceSheets.push({
				//Current Assets:
				releaseDate: "", //heading
				cashAndEquivalents: null,
				shortTermInvestments: null,
				netRecievables: null,
				inventory: null,
				otherCurrentAssets: null,
				currentAssetsSum: null,
				//Current Liabilities 		//Sub-heading
				accountsPayable: null,
				currentLongTermDebt: null,
				otherCurrentLiabilities: null,
				currentLiabilitiesSum: null,
				//Stockholders Equity		//Sub-heading
				miscStockOptionWarrants: null,
				redeemablePreferredStock: null
			})
		},
		deleteBalanceSheet(index) {
			this.localBalanceSheets.splice(index, 1)
		},
		currentAssetsSumMethod(index) {
			this.localBalanceSheets[index].currentAssetsSum.value = Number(this.localBalanceSheets[index].cashAndEquivalents.value) + Number(this.localBalanceSheets[index].shortTermInvestments.value)
			return this.localBalanceSheets[index].currentAssetsSum.value
		},
		denominationChange() {
			//Should I update the number values to reflect the actual size of the number, or ... ?
		},
		validateNumber(numberObject) {
			if(Number.isNaN(numberObject.value)){
				numberObject.error = "Value must be a number"
				return false
			}
			return true
		}
	}
}


/* END__END__END

		<table>
			<tbody v-for="(bs, index) in balanceSheets" style="float: left;">
				<tr>
					<th v-model="bs.releaseDate">{{ bs.releaseDate }}</th>
				</tr>
				<tr>
					<td v-model="bs.cashAndEquivalents">{{ bs.cashAndEquivalents }}</td>
				</tr>
				<tr>
					<td v-model="bs.shortTermInvestments">{{ bs.shortTermInvestments }}</td>
				</tr>
				<tr>
					<th>Current Liabilities</th>
				</tr>
				<tr>
					<td v-model="bs.accountsPayable">{{ bs.accountsPayable }}</td>
				</tr>
				<tr>
					<td v-model="bs.currentLongTermDebt">{{ bs.currentLongTermDebt }}</td>
				</tr>
				<tr>
					<td v-model="bs.otherCurrentLiabilities">{{ bs.otherCurrentLiabilities }}</td>
				</tr>
				<tr>
					<th>Stockholders Equity</th>
				</tr>
				<tr>
					<td v-model="bs.miscStockOptionWarrants">{{ bs.miscStockOptionWarrants }}</td>
				</tr>
				<tr>
					<td v-model="bs.redeemablePreferredStock">{{ bs.redeemablePreferredStock }}</td>
				</tr>

			</tbody>
		</table>

		<table>
			<tbody>
				<tr>
					<td v-for="bs in balanceSheets">{{ bs.releaseDate }}</td>
				</tr>
				<tr>
					<td v-for="bs in balanceSheets">{{ bs.cashAndEquivalents }}</td>
				</tr>
				<tr>
					<td v-for="bs in balanceSheets">{{ bs.shortTermInvestments }}</td>
				</tr>
				<tr>
					<th colspan="1">Current Liabilities</th>
				</tr>
				<!-- Grouping  -->

					<tr>
						<td v-for="bs in balanceSheets">{{ bs.accountsPayable }}</td>
					</tr>
					<tr>
						<td v-for="bs in balanceSheets">{{ bs.currentLongTermDebt }}</td>
					</tr>
					<tr>
						<td v-for="bs in balanceSheets">{{ bs.otherCurrentLiabilities }}</td>
					</tr>

				<!-- Grouped Item sums -->
				<div>
					<tr>
						<td v-for="bs in balanceSheets">{{ bs.currentLiabilitiesSum }}</td>
					</tr>
				</div>

				<tr>
					<th colspan="1">Stockholders Equity</th>
				</tr>
				<tr>
					<td v-for="bs in balanceSheets">{{ bs.miscStockOptionWarrants }}</td>
				</tr>
				<tr>
					<td v-for="bs in balanceSheets">{{ bs.redeemablePreferredStock }}</td>
				</tr>


			</tbody>
		</table>
				<!--
		<div class="Table">
			<div class="Table__top">
				<button @click="newBalanceSheet">New Balance Sheet</button>
			</div>
			<div class="Table__sidebar">

			</div>

			<div v-for="(bs, index) in localBalanceSheets" class="Table__column">
				<p>{{ index }}</p>
				<div class="Collapsable">
					<div class="Table__element" v-if="index === 0">
						<div class="Table__data">
							<button @click="dropdown">Show/hide</button>
						</div>
					</div>
					<div class="Table__element" v-if="index > 0">
						<div class="Table__data"></div>
					</div>
					
					<div class="Table__element">
						<input class="Table__data" v-model="bs.releaseDate">
					</div>
					<div class="Table__element">
						<input class="Table__data" v-model="bs.cashAndEquivalents">
					</div>
					<div class="Table__element">
						<input class="Table__data" v-model="bs.shortTermInvestments">
					</div>

					<div class="Table__element Collapsable__sum">
						<span class="Table__data">{{ bs.currentAssetsSum }}</span>
					</div>
				</div>


          		<details>
          			<summary>
          				Current Assets
          			</summary>
					<p>
						<div v-for="(bs, index) in localBalanceSheets">
							<div class="Table__element">
								<input class="Table__data" v-model="bs.releaseDate">
							</div>
							<div class="Table__element">
								<input class="Table__data" v-model="bs.cashAndEquivalents">
							</div>
							<div class="Table__element">
								<input class="Table__data" v-model="bs.shortTermInvestments">
							</div>
						</div>
					</p>
				</details>
				<div v-for="(bs, index) in localBalanceSheets" class="Table__element Collapsable__sum">
					<span class="Table__data">{{ currentAssetsSumMethod(index) }}</span>
				</div>




				<div>
					<div v-if="index === 0">Current Liabilities</div>
				</div>
				<div>
					<div v-model="bs.accountsPayable">{{ bs.accountsPayable }}</div>
				</div>
				<div>
					<div v-model="bs.currentLongTermDebt">{{ bs.currentLongTermDebt }}</div>
				</div>
				<div>
					<div v-model="bs.otherCurrentLiabilities">{{ bs.otherCurrentLiabilities }}</div>
				</div>
				<div>
					<div v-if="index === 0">Stockholders Equity</div>
				</div>
				<div>
					<div v-model="bs.miscStockOptionWarrants">{{ bs.miscStockOptionWarrants }}</div>
				</div>
				<div>
					<div v-model="bs.redeemablePreferredStock">{{ bs.redeemablePreferredStock }}</div>
				</div>
			</div>

		</div>
		-->

*/

</script>







