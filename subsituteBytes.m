function [ new_state ] = subsituteBytes( state , box )
%UNTITLED5 Summary of this function goes here
%   Detailed explanation goes here

for r=1:4
    for c = 1:4
      new_state(c,r) =  subsitute( state(c,r),box );
    end
    
end

end

