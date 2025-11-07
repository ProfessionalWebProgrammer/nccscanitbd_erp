<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PayRoll\EmployeeReportController;
use App\Http\Controllers\PayRoll\EmployeeLeaveSystemController;
use App\Http\Controllers\Account\IndividualAccountController;
use App\Http\Controllers\Account\SubSubAccountController;
use App\Http\Controllers\Account\ChartOfAccountController;
use App\Http\Controllers\Account\SubAccountController;

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('emp-final-settlement-report-input',[EmployeeReportController::class,'employeeFinalSettlementReportInput'])->name('emp.final.settlement.report.input');
    Route::post('emp-final-settlement-report',[EmployeeReportController::class,'employeeFinalSettlementReport'])->name('emp.final.settlement.report');
    Route::get('emp-leave-report-input',[EmployeeReportController::class,'employeeLeaveReportInput'])->name('emp.leave.report.input');
    Route::post('emp-leave-report',[EmployeeReportController::class,'employeeLeaveReport'])->name('emp.leave.report');
    Route::get('emp-attendence-job-report-input',[EmployeeReportController::class,'employeeAttendenceJobReportInput'])->name('emp.attendence.job.report.input');
    Route::post('emp-attendence-job-report',[EmployeeReportController::class,'employeeAttendenceJobReport'])->name('emp.attendence.job.report');
    Route::get('emp-payslip-report-input',[EmployeeReportController::class,'employeePayslipReportInput'])->name('emp.payslip.report.input');
    Route::post('emp-payslip-report',[EmployeeReportController::class,'employeePayslipReport'])->name('emp.payslip.report');
    Route::get('emp-worker-payslip-report-input',[EmployeeReportController::class,'employeeWorkerPayslipReportInput'])->name('emp.worker.payslip.report.input');
    Route::post('emp-worker-payslip-report',[EmployeeReportController::class,'employeeWorkerPayslipReport'])->name('emp.worker.payslip.report');
    Route::get('emp-working-report-input',[EmployeeReportController::class,'employeeWorkingReportInput'])->name('emp.working.report.input');
    Route::post('emp-working-report',[EmployeeReportController::class,'employeeWorkingReport'])->name('emp.working.report');

    Route::get('emp-salary-sheet-input', [EmployeeReportController::class, 'empSalaryreportInput'])->name('emp.salary.sheet.input');
    Route::post('emp-salary-sheet-report', [EmployeeReportController::class, 'empSalaryreport'])->name('emp.salary.sheet.report');

   //emp Leave policy
   Route::get('emp-leave-policy-list',[EmployeeLeaveSystemController::class,'empLeavePolicyList'])->name('emp.leave.policy.list');
   Route::get('emp-leave-policy-create',[EmployeeLeaveSystemController::class,'empLeavePolicyCreate'])->name('emp.leave.policy.create');
   Route::post('emp-leave-policy-store',[EmployeeLeaveSystemController::class,'empLeavePolicyStore'])->name('emp.leave.policy.store');
   Route::get('emp-leave-policy-edit/{id}',[EmployeeLeaveSystemController::class,'empLeavePolicyEdit'])->name('emp.leave.policy.edit');
   Route::put('emp-leave-policy-update/{id}',[EmployeeLeaveSystemController::class,'empLeavePolicyUpdate'])->name('emp.leave.policy.update');
   Route::delete('emp-leave-policy-delete',[EmployeeLeaveSystemController::class,'empLeavePolicyDelete'])->name('emp.leave.policy.delete');

   Route::get('emp-leave-of-absence-approve',[EmployeeLeaveSystemController::class,'empLeaveOfAbsenceStatusApprove'])->name('emp.leave.of.absence.approve');


   //Individual Account
    Route::get('account/individual/list', [IndividualAccountController::class, 'index'])->name('individual.account.list');
    Route::get('account/individual/create', [IndividualAccountController::class, 'create'])->name('individual.account.create');
    Route::post('account/individual/store', [IndividualAccountController::class, 'store'])->name('individual.account.store');
    Route::delete('account/individual/delete', [IndividualAccountController::class, 'destroy'])->name('individual.account.delete');

    Route::get('account/sub-sub/list', [SubSubAccountController::class, 'index'])->name('sub.sub.account.list');
    Route::get('account/sub-sub/create', [SubSubAccountController::class, 'create'])->name('sub.sub.account.create');
    Route::post('account/sub-sub/store', [SubSubAccountController::class, 'store'])->name('sub.sub.account.store');
    Route::delete('account/sub-sub/delete', [SubSubAccountController::class, 'destroy'])->name('sub.sub.account.delete');

    Route::get('account/sub/list', [SubAccountController::class, 'index'])->name('sub.account.list');
    Route::get('account/sub/create', [SubAccountController::class, 'create'])->name('sub.account.create');
    Route::post('account/sub/store', [SubAccountController::class, 'store'])->name('sub.account.store');
    Route::delete('account/sub/delete', [SubAccountController::class, 'destroy'])->name('sub.account.delete');

    Route::get('account/chat-of-account/list', [ChartOfAccountController::class, 'index'])->name('chat.of.account.list');
    Route::get('account/chat-of-account/trail/balance/input', [ChartOfAccountController::class, 'inputTrailBalanceSheet'])->name('chat.of.account.trail.balance.input');
    Route::get('account/chat-of-account/trail-balance', [ChartOfAccountController::class, 'getTrailBalanceSheet'])->name('chat.of.account.trail.balance');
    Route::get('account/chat-of-account/balance/sheet/input', [ChartOfAccountController::class, 'inputBalanceSheet'])->name('chat.of.account.balance.sheet.input');
    Route::get('account/chat-of-account/balance-sheet', [ChartOfAccountController::class, 'balanceSheet'])->name('chat.of.account.balance.sheet');
    Route::get('account/chat-of-account/depreciation', [ChartOfAccountController::class, 'getDepreciation'])->name('get.chat.of.account.depreciation');
    Route::get('account/chat-of-account/depreciation/update/{id}', [ChartOfAccountController::class, 'storeDepreciation'])->name('update.chat.of.account.depreciation');

    Route::get('account/chat-of-account/income/statement/input', [ChartOfAccountController::class, 'inputIncomeStatement'])->name('chat.of.account.income.statement.input');
    Route::get('account/chat-of-account/income/statement', [ChartOfAccountController::class, 'getIncomeStatement'])->name('chat.of.account.income.statement');

    Route::get('account/chat-of-account/journal/input', [ChartOfAccountController::class, 'inputJournal'])->name('chat.of.account.journal.input');
    Route::get('account/chat-of-account/journal', [ChartOfAccountController::class, 'getJournal'])->name('chat.of.account.journal');
    //Extemded TB
    Route::get('account/chat-of-account/extendedTrailBalance/input', [ChartOfAccountController::class, 'inputExtendedTrailBalanceSheet'])->name('chat.of.account.extended.trail.balance.input');
    Route::get('account/chat-of-account/extendedTrailBalance/view', [ChartOfAccountController::class, 'getExtendedTrailBalanceSheet'])->name('chat.of.account.extended.trail.balance');

});
