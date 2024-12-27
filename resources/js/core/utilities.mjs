function when(condition, trueValue, defaultValue =  null){
    if (condition){
        return is(typeof trueValue, "function") ?
        trueValue() : trueValue;
    }else{
        if (defaultValue){
            return !isNull(defaultValue) && is(typeof defaultValue, "function")
            ? defaultValue() : defaultValue;
        }
        return null;
    }
}
function taskStatusSeverity(status){
    let severity = null;
    switch(status){
        case "WAT" :
            severity = "warning";
            break;
        case "PRO" :
            severity = "primary";
            break;
        case "CON" :
            severity = "success";
            break;
        default : severity = "secondary";
    }
    return severity;
}
function prioritySeverity(priority){
    if(priority === "ALT")  return "danger";
    if (priority === "MED") return "warning";
    if (priority === "BAX") return "success";
    return "secondary";
}
function statusColor(desc){
    let color = "";
    switch(desc){
        case "WAT" :
            color = "#7c3aed";
            break;
        case "PRO" :
            color = "#0ea5e9";
            break;
       case "CDR" :
            color = "#9333ea";
            break;
        case "CON" :
            color = "#10b981";
            break;
        case "TST" :
            color = "#f59e0b";
            break;
        case "BKL" :
            color = "#94a3b8";
            break;
        case "PRQ" :
            color = "#e11d48";
            break;
        case "BLOCK":
            color = "#e11d48";
            break;
        default :
            color = "#7c3aed";
            break;
    }
    return color;
}
const isNull = (arg) => arg == null;
const isNullOrWhiteSpace = (arg) => arg == null || arg == "";
const is = (arg, value) => arg == value;

export {
    isNull,
    isNullOrWhiteSpace,
    taskStatusSeverity,
    prioritySeverity,
    statusColor,
    when,
    is
}

