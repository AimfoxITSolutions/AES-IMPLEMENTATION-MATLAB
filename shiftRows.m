function [ new_state ] = shiftRows( state )
%UNTITLED6 Summary of this function goes here
%   Detailed explanation goes here

new_state(1,:) = state(1,:);
t = state(2,:);
new_state(2,:) = [t(2) , t(3) , t(4) , t(1)];
t = state(3,:);
new_state(3,:) = [t(3) , t(4) , t(1) , t(2)];
t = state(4,:);

new_state(4,:) = [t(4) , t(1) , t(2) , t(3)];
end

