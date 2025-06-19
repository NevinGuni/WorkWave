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