<!DOCTYPE html>
<html>
<head>
    <title>Department Analysis</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .report-container {
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .page-header {
            position: relative;
            background-color: #4a4a4a;
            color: white;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .back-btn {
            position: absolute;
            left: 30px;
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            transition: color 0.3s ease;
        }
        .back-btn:hover {
            color: #4CAF50;
        }
        .report-summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .summary-item {
            text-align: center;
        }
        .summary-number {
            font-size: 24px;
            font-weight: bold;
            color: #4a4a4a;
        }
        .summary-label {
            font-size: 14px;
            color: #777;
        }
        .report-actions {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .action-btn {
            background-color: #f1f3f5;
            color: #333;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }
        .action-btn:hover {
            background-color: #e9ecef;
        }
        .print-btn {
            background-color: #4CAF50;
            color: white;
        }
        .print-btn:hover {
            background-color: #45a049;
        }
        .department-tree {
            margin-top: 20px;
        }
        .department-item {
            display: flex;
            align-items: flex-start;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 5px;
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }
        .department-item:hover {
            background-color: #e9ecef;
        }
        .toggle-icon, .toggle-icon-placeholder {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            background-color: #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
        }
        .toggle-icon-placeholder {
            visibility: hidden;
        }
        .department-info {
            flex: 1;
            display: flex;
            align-items: center;
        }
        .dept-name {
            flex: 2;
            font-weight: bold;
        }
        .employee-count {
            flex: 1;
            text-align: right;
            color: #666;
        }
        .percentage-bar {
            flex: 2;
            height: 10px;
            background-color: #eee;
            border-radius: 5px;
            margin: 0 15px;
            overflow: hidden;
        }
        .percentage-fill {
            height: 100%;
            background-color: #4CAF50;
        }
        .percentage-text {
            flex: 0.5;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
        .children-container {
            margin-left: 30px;
        }
        @media print {
            .report-actions, .back-btn {
                display: none;
            }
            .report-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
            .department-item {
                break-inside: avoid;
            }
            body {
                background-color: white;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="page-header">
            <a href="{{ route('admin.dashboard') }}" class="back-btn">← Back to Dashboard</a>
            <h1>Department Analysis</h1>
        </div>
        
        <div class="report-summary">
            <div class="summary-item">
                <div class="summary-number">{{ $departments->count() }}</div>
                <div class="summary-label">Total Departments</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ $total_employees }}</div>
                <div class="summary-label">Total Employees</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ $topLevelCount }}</div>
                <div class="summary-label">Top-Level Departments</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ $maxDepth }}</div>
                <div class="summary-label">Hierarchy Levels</div>
            </div>
        </div>
        
        <div class="report-actions">
            <button class="action-btn" id="expand-all">Expand All</button>
            <button class="action-btn" id="collapse-all">Collapse All</button>
            <button class="action-btn print-btn" onclick="window.print()">Print Report</button>
        </div>
        
        <div class="department-tree">
            @foreach($topLevelDepartments as $dept)
                <div class="department-item {{ $dept->children->count() > 0 ? 'has-children' : '' }}">
                    @if($dept->children->count() > 0)
                        <span class="toggle-icon">+</span>
                    @else
                        <span class="toggle-icon-placeholder"></span>
                    @endif
                    
                    <div class="department-info">
                        <div class="dept-name">{{ $dept->name }}</div>
                        <div class="employee-count">{{ $dept->employee_count }} employees</div>
                        <div class="percentage-bar">
                            <div class="percentage-fill" style="width: {{ $total_employees > 0 ? round(($dept->employee_count / $total_employees) * 100, 1) : 0 }}%;"></div>
                        </div>
                        <div class="percentage-text">{{ $total_employees > 0 ? round(($dept->employee_count / $total_employees) * 100, 1) : 0 }}%</div>
                    </div>
                    
                    @if($dept->children->count() > 0)
                        <div class="children-container" style="display: none;">
                            @foreach($dept->children as $child)
                                @include('admin.partials.department_tree_item', ['dept' => $child, 'total_employees' => $total_employees])
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
         
            document.querySelectorAll('.toggle-icon').forEach(function(icon) {
                icon.addEventListener('click', function() {
                    const departmentItem = this.closest('.department-item');
                    const childrenContainer = departmentItem.querySelector('.children-container');
                    
                    if (childrenContainer.style.display === 'none') {
                        childrenContainer.style.display = 'block';
                        this.textContent = '-';
                    } else {
                        childrenContainer.style.display = 'none';
                        this.textContent = '+';
                    }
                });
            });
            
            document.getElementById('expand-all').addEventListener('click', function() {
                document.querySelectorAll('.children-container').forEach(function(container) {
                    container.style.display = 'block';
                });
                document.querySelectorAll('.toggle-icon').forEach(function(icon) {
                    icon.textContent = '-';
                });
            });
                    
            document.getElementById('collapse-all').addEventListener('click', function() {
                document.querySelectorAll('.children-container').forEach(function(container) {
                    container.style.display = 'none';
                });
                document.querySelectorAll('.toggle-icon').forEach(function(icon) {
                    icon.textContent = '+';
                });
            });
        });
    </script>
</body>
</html>